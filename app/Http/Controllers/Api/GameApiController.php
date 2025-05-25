<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class GameApiController extends Controller
{

    // TODOS
    public function index()
    {
        $games = Game::with([
            'genres:id,name',
            'platforms:id,name',
            'gameModes:id,name',
            'themes:id,name',
            'saga:id,name',
            'users' => function($query) {
                $query->select('users.id', 'name')
                    ->withPivot(['state', 'user_score', 'hours_played']);
            }
        ])
        ->withCount('users as total_players')
        ->get()
        ->map(function($game) {
            return [
                // info juego
                'id' => $game->id,
                'title' => $game->title,
                'description' => $game->description,
                'image_url' => $game->image_url,
                'release_date' => $game->release_date,
                'developer' => $game->developer,
                'price' => $game->price,

                'genres' => $game->genres,
                'platforms' => $game->platforms,
                'game_modes' => $game->gameModes,
                'themes' => $game->themes,
                'saga' => $game->saga,

                // Stats del jeugo
                'total_players' => $game->total_players,
                'average_score' => $game->users->avg('pivot.user_score'),
                'popularity' => $game->users->count(),

                // Jugadores recientes (PRUEBAS, FALTA PULIR, tarea para el pablo del futuro.)
                'recent_players' => $game->users->take(3)->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'hours_played' => $user->pivot->hours_played
                    ];
                })
            ];
        });

        return response()->json(['data' => $games]);
    }

    // stats de 1
    public function gameStats($id){
    $game = Game::withCount('users as total_players')
        ->with(['users' => function($query) {
            $query->select('users.id')->withPivot('user_score');
        }])
        ->findOrFail($id);

    $allGames = Game::withCount('users')
        ->with(['users' => function($query) {
            $query->select('users.id')->withPivot('user_score');
        }])
        ->get()
        ->map(function($g) {
            return [
                'id' => $g->id,
                'average_score' => $g->users->avg('pivot.user_score'),
                'total_players' => $g->users_count
            ];
        })
        ->filter(fn($g) => $g['average_score'] !== null)
        ->sortByDesc('average_score')
        ->values();

    $rank = $allGames->search(fn($g) => $g['id'] == $id) + 1;

    return response()->json([
        'total_players' => $game->total_players,
        'average_score' => $game->users->avg('pivot.user_score'),
        'popularity' => $game->users->count(),
        'rank' => $rank <= count($allGames) ? $rank : null
    ]);
}

   // 1 juego
   public function show($id){
       return Game::with([
           'genres',
           'platforms',
           'gameModes',
           'themes',
           'saga',
           'users' => function($query) {
               $query->select('users.id', 'name')->limit(5);
           }
       ])->findOrFail($id);
   }

    // Buscar juego
    public function search(Request $request){
        $query = $request->input('query');
        $games = Game::where('title','like','%'.$query.'%')
        ->with([
            'genres:id,name',
            'platforms:id,name',
            'gameModes:id,name',
            'themes:id,name',
            'saga:id,name'
        ])
        ->select('id','title','description','release_date','developer','publisher','price','achievements','image_url')
        ->take(10)
        ->get();

        return response()->json(['games' => $games]);
    }

    // Comparador de jeugos para el usuario
    public function compare(Request $request){
    }

    // similares (para rellenar huecos...)
    public function similarGames(Game $game)
    {
        return $game->genres()
            ->first()
            ->games()
            ->where('id', '!=', $game->id)
            ->with(['genres', 'platforms'])
            ->limit(5)
            ->get();
    }

    // misma sagas
    public function sameSaga(Game $game) {
        if (!$game->saga) {
            return response()->json(['games' => []]);
        }
        $games = $game->saga->games()->where('id', '!=', $game->id)->inRandomOrder()->take(3)->get();

        return response()->json(['games' => $games]);
    }

    // ultimos lanzamientos
    public function latestGames(){
    $games = Game::with(['genres:id,name', 'platforms:id,name'])
        ->orderBy('release_date', 'desc')
        ->take(10)
        ->get();

    return response()->json(['data' => $games]);
}

    // STATS GLBALES DE PIXOLLECT
    public function globalStats(){
            return response()->json([
                'total_users' => User::count(),
                'total_games' => Game::count(),
            ]);
    }

    // subir 1 achievements
    public function incrementAchievement(Request $request, $gameId) {

        $user = $request->user();
        $game = Game::findOrFail($gameId);

        $userGame = $user->games()->where('game_id', $gameId)->first();

        $newCount = $userGame->pivot->achievements_unlocked + 1;
        $maxAchievements = $game->achievements;

        $updateData = ['achievements_unlocked' => min($newCount, $maxAchievements)];

        if ($newCount >= $maxAchievements) {
            $updateData['state'] = 'completed';
            $updateData['mastered'] = true;
        }

        $user->games()->updateExistingPivot($gameId, $updateData);

        return response()->json([
            'message' => $newCount >= $maxAchievements
                ? 'Congratulations! You mastered this game!'
                : 'Achievement unlocked!',
            'achievements_unlocked' => $updateData['achievements_unlocked'],
            'state' => $updateData['state'] ?? $userGame->pivot->state,
            'mastered' => $updateData['mastered'] ?? false
        ]);

    }

   // Recomendador de juegos para el usuario
    public function recommendByTags($userId){
        $cacheKey = "recommendations_user_{$userId}_" . now()->format('Y-m-d');

        $recommendations = Cache::remember($cacheKey, 86400, function () use ($userId) {
            $user = User::with(['games' => function ($q) {
                $q->withPivot(['user_score', 'hours_played']);
            }, 'games.genres', 'games.themes', 'games.platforms', 'games.gameModes', 'games.saga'])->findOrFail($userId);

            $weights = [
                'genres' => [],
                'themes' => [],
                'platforms' => [],
                'game_modes' => [],
                'sagas' => [],
                'developers' => [],
                'publishers' => [],
            ];

            $totalPrice = 0;
            $ownedGameIds = [];

            foreach ($user->games as $game) {
                $ownedGameIds[] = $game->id;
                $multiplier = ($game->pivot->user_score ?? 5) + ($game->pivot->hours_played / 2);

                foreach ($game->genres as $genre) {
                    $weights['genres'][$genre->id] = ($weights['genres'][$genre->id] ?? 0) + 3 * $multiplier;
                }

                foreach ($game->themes as $theme) {
                    $weights['themes'][$theme->id] = ($weights['themes'][$theme->id] ?? 0) + 2 * $multiplier;
                }

                foreach ($game->platforms as $platform) {
                    $weights['platforms'][$platform->id] = ($weights['platforms'][$platform->id] ?? 0) + 1 * $multiplier;
                }

                foreach ($game->gameModes as $mode) {
                    $weights['game_modes'][$mode->id] = ($weights['game_modes'][$mode->id] ?? 0) + 2 * $multiplier;
                }

                if ($game->saga_id) {
                    $weights['sagas'][$game->saga_id] = ($weights['sagas'][$game->saga_id] ?? 0) + 5 * $multiplier;
                }

                if ($game->developer) {
                    $weights['developers'][$game->developer] = ($weights['developers'][$game->developer] ?? 0) + 2 * $multiplier;
                }

                if ($game->publisher) {
                    $weights['publishers'][$game->publisher] = ($weights['publishers'][$game->publisher] ?? 0) + 1 * $multiplier;
                }

                $totalPrice += $game->price;
            }

            $avgPrice = count($user->games) ? $totalPrice / count($user->games) : 0;

            $candidates = Game::with(['genres', 'themes', 'platforms', 'gameModes', 'saga'])
                ->whereNotIn('id', $ownedGameIds)
                ->get();

            $ranked = $candidates->map(function ($game) use ($weights, $avgPrice) {
                $score = 0;

                foreach ($game->genres as $genre) {
                    $score += $weights['genres'][$genre->id] ?? 0;
                }

                foreach ($game->themes as $theme) {
                    $score += $weights['themes'][$theme->id] ?? 0;
                }

                foreach ($game->platforms as $platform) {
                    $score += $weights['platforms'][$platform->id] ?? 0;
                }

                foreach ($game->gameModes as $mode) {
                    $score += $weights['game_modes'][$mode->id] ?? 0;
                }

                if ($game->saga_id) {
                    $score += $weights['sagas'][$game->saga_id] ?? 0;
                }

                if ($game->developer) {
                    $score += $weights['developers'][$game->developer] ?? 0;
                }

                if ($game->publisher) {
                    $score += $weights['publishers'][$game->publisher] ?? 0;
                }

                if ($avgPrice > 0 && $game->price > 0 && abs($game->price - $avgPrice) <= ($avgPrice * 0.25)) {
                    $score += 2;
                }

                if ($game->release_date && now()->diffInYears($game->release_date) <= 3) {
                    $score += 1;
                }

                return ['game' => $game, 'score' => $score];
            });

            // Top 100
            $top100 = $ranked->sortByDesc('score')->take(100)->values();

            $seed = strtotime(now()->format('Y-m-d'));
            mt_srand($seed);
            $shuffled = $top100->shuffle();

            return $shuffled->take(10)->values();
        });

        return response()->json($recommendations);
    }



}

