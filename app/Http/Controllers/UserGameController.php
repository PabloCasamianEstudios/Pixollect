<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserGameController extends Controller
{
    // crear relación juegos del usuario TODAVÍA ESTÁ EN PRUEBAS, POR ESO ESTABLEZCO LOS VALORES DEL JUEGO
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

    // borrar juego de la colección
    public function destroy($gameId) {
        $user = Auth::user();

        if (!$user->games()->where('game_id', $gameId)->exists()) {
            return back()->withErrors([
                'error' => 'NO ESTÁ.'
            ]);
        }

        $user->games()->detach($gameId);

        return back()->with('success', 'Game removed from your collection successfully');

    }

}
