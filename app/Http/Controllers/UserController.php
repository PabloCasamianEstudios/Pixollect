<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $users = User::with('games')->select('id','name','avatar_url')->get();
        return Inertia::render('Collections', [
            'users' => $users,
        ]);
    }

}
