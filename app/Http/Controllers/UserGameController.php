<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserGameController extends Controller
{
    // crear relación juegos del usuario
    public function store(Game $game){
        $user = Auth::user();

        if ($user->games()->where('game_id', $game->id)->exists()) {
            return back()->withErrors(['message' => 'Already added']);
        }

        $user->games()->attach($game->id, [
            'state' => 'planned',
            'progress' => 0,
            'user_score' => null,
            'mastered' => false,
        ]);

        if ($user->games()->where('game_id', $game->id)->exists()) {
            return back()->withErrors(['message' => 'Already added']);
        }

        return back();
    }

}
