<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller {

    //  principal user
    public function show(User $user){
    $gamesCount = $user->games()->count();
    $userGames = $user->games()->withPivot('state','mastered','user_score','comment','progress','achievements_unlocked','hours_played','start_date','end_date')->get();



    return Inertia::render('User/Profile', [
        'user' => $user,
        'gamesCount' => $gamesCount,
        'userGames' => $userGames,
    ]);

}


// Sacar los juegos del usuario
public function games(User $user) {
    $games = $user->games()->with(['genres', 'platforms', 'themes'])->get();

    return Inertia::render('User/Games', [
        'user' => $user,
        'games' => $games,
    ]);
}

    // sacar todas las collections
    public function collections() {
        $users = User::with('games')->select('id','name','avatar_url','role')->get();
        return Inertia::render('Collections', [
            'users' => $users,
        ]);
    }


/**
 * Cambiar foto de perfil de un usuario
 */
public function updateAvatar(Request $request, User $user) {
    $validated = $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
        unlink(public_path($user->avatar_url));
    }

    $filename = time().'.'.$request->avatar->extension();
    $request->avatar->move(public_path('avatars'), $filename);

    $user->update([
        'avatar_url' => '/avatars/'.$filename
    ]);

    return back()->with('message', 'Updated profile picture.');
}

// setting del usuario
public function editSettings(User $user)
{
    if (Auth::id() !== $user->id) {
        abort(403);
    }

    return Inertia::render('User/Settings', [
        'user' => $user,
    ]);
}

public function updateSettings(Request $request, User $user)
{
    if (Auth::id() !== $user->id) {
        abort(403);
    }

    $request->validate([
        'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'current_password' => ['required'],
        'password' => ['nullable', 'confirmed', 'min:8'],
    ]);

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Incorrect current password.']);
    }

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return back()->with('message', 'Account settings updated.');
}

// contadores de cada usuario
public function getUserCounts($userId) {
    $user = User::findOrFail($userId);

    $games = $user->games()
        ->withPivot([
            'hours_played',
            'achievements_unlocked'
        ])
        ->get();

    $stats = [
        'total_games' => 0,
        'total_hours' => 0,
        'total_achievements' => 0,
        'total_spent' => 0
    ];

    foreach ($games as $game) {
        $hours = floatval($game->pivot->hours_played) ?? 0;
        $achievements = intval($game->pivot->achievements_unlocked) ?? 0;
        $price = floatval($game->price) ?? 0;

        $stats['total_games']++;
        $stats['total_hours'] += $hours;
        $stats['total_achievements'] += $achievements;
        $stats['total_spent'] += $price;
    }

    return response()->json($stats);
}

// STATS
public function getUserStats($userId) {
    $user = User::findOrFail($userId);

    return response()->json([
        'gamesByGenre' => $this->getGamesByGenreStats($user),
        'gamesByState' => $this->getGamesByStateStats($user),
        'gamesBySaga' => $this->getGamesBySagaStats($user),
        'gamesMastered' => [
            'mastered_count' => $user->games()->wherePivot('mastered', true)->count(),
            'not_mastered_count' => $user->games()->wherePivot('mastered', false)->count()
        ]
          ]);
}

protected function getGamesByGenreStats(User $user){
    return $user->games()
        ->with('genres:id,name')
        ->get()
        ->flatMap(function ($game) {
            return $game->genres->map(function ($genre) {
                return [
                    'id' => $genre->id,
                    'name' => $genre->name
                ];
            });
        })
        ->groupBy('name')
        ->map(function ($items, $genreName) {
            return [
                'title' => $genreName,
                'userGames' => count($items)
            ];
        })
        ->values()
        ->sortByDesc('userGames')
        ->take(10)
        ->values();
}

protected function getGamesByStateStats(User $user){
    return $user->games()
        ->get()
        ->groupBy('pivot.state')
        ->map(function ($games, $state) {
            return [
                'title' => ucfirst($state),
                'count' => $games->count()
            ];
        })
        ->values()
        ->sortByDesc('count')
        ->values();
}

protected function getGamesBySagaStats(User $user){
    return $user->games()
        ->with('saga:id,name')
        ->get()
        ->groupBy('saga.name')
        ->map(function ($games, $sagaName) {
            return [
                'title' => $sagaName ?: 'Sin saga',
                'count' => $games->count(),
                'hours' => $games->sum('pivot.hours_played')
            ];
        })
        ->values()
        ->sortByDesc('count')
        ->values();
}

protected function getGamesMasteredStats(User $user) {
    $mastered = $user->games()->wherePivot('mastered', true)->count();
    $notMastered = $user->games()->wherePivot('mastered', false)->count();

    return [
        'mastered_count' => $mastered,
        'not_mastered_count' => $notMastered
    ];
}

public function updateRole(Request $request, $id){
    $request->validate([
        'role' => 'required|in:admin,user,mute,deleteuser',
    ]);

    $currentUser = Auth::user();

    if ($currentUser->role !== 'admin') {
        abort(403);
    }

    $user = User::findOrFail($id);

    if ($request->role === 'deleteuser') {
        $user->delete();
        return redirect()->back()->with('message', 'Deleted user.');
    }

    $user->role = $request->role;
    $user->save();

    return redirect()->back()->with('message', 'Updated role.');
}


// los achievements del sitio (todo esto por no añadirlo al user: NOTA PARA EL PABLO DEL FUTURO)
public function achievements(User $user) {
    $games = $user->games()
        ->with(['genres', 'platforms', 'themes'])
        ->withPivot([
            'state', 'mastered', 'user_score', 'comment',
            'progress', 'achievements_unlocked', 'hours_played',
            'start_date', 'end_date'
        ])
        ->get();
    $stats = [
        'total_games' => $games->count(),
        'total_hours' => $games->sum('pivot.hours_played'),
        'total_achievements' => $games->sum('pivot.achievements_unlocked'),
        'rated_games' => $games->where('pivot.user_score', '>', 0)->count(),
        'completed_games' => $games->where('pivot.state', 'completed')->count(),
        'mastered_games' => $games->where('pivot.mastered', true)->count(),
        'unique_genres' => $games->flatMap->genres->unique('id')->count(),
    ];

    return Inertia::render('User/Achievements', [
        'user' => $user,
        'stats' => $stats,
    ]);
}


 public function index() {
        $users = User::withCount('games')
            ->orderBy('id')
            ->get();

        return Inertia::render('Users/Index', [
            'users' => $users,
            'successMessage' => session('success'),
        ]);
}


public function destroy( User $user) {
    $user->delete();
    return redirect()->route('users.index')->with('message', 'User deleted successfully.');

}


public function edit(User $user){
    return Inertia::render('Users/Edit', [
        'user' => $user,
    ]);
}

public function update(Request $request, User $user){
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6',
        'avatar_url' => 'nullable|url',
        'role' => 'required|in:user,admin',
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->avatar_url = $validated['avatar_url'] ?: '/images/defaultIcon.png';
    $user->role = $validated['role'];


    $user->avatar_url = $validated['avatar_url'] ?? null;
    if (empty($user->avatar_url)) {
        $user->avatar_url = '/images/defaultIcon.png';
    }

    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->route('users.index')->with('message', 'User updated successfully.');
}

}
