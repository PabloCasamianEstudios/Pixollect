<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameApiController extends Controller
{

    // TODOS
    // En tu GameApiController.php
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
   // 1 juego
   public function show($id)
   {
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

    // Recomendador de juegos para el usuario
    public function recommendByTags($userId){

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

}
