<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
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


    // obtener todos los juegos de un user
    public function getUserGames($userId) {
        $user = User::with(['games' => function ($query) {
            $query->with('genres', 'platforms');
        }])->findOrFail($userId);

        return response()->json([
            'games' => $user->games,
        ]);
    }

    // todas horas de un user en todos sus juegos
    public function getTotalHours ($userId) {
        $user = User::findOrFail($userId);

        $totalHours = $user->games()->sum('playtime');

        return response()->json([
            'total_hours' => $totalHours,
        ]);
    }

}
