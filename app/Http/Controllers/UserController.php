<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function show(User $user){
    $gamesCount = $user->games()->count();
    $userGames = $user->games();

    return Inertia::render('User/Profile', [
        'user' => $user,
        'gamesCount' => $gamesCount,
        'userGames' => $userGames,
    ]);
}
}
