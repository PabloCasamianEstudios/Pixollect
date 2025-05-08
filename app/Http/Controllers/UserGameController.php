<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserGameController extends Controller
{
    public function store(Request $request, Game $game){
        $user = Auth::user();

        if ($user->games()->where('game_id', $game->id)->exists()) {
            return back()->withErrors(['message' => 'Already added']);
        }

        if ($user->games()->where('game_id', $game->id)->exists()) {
            return back()->withErrors(['message' => 'Already added']);
        }

        $validated = $request->validate([
            'status' => 'required|string',
            'rating' => 'nullable|numeric|min:0|max:10',
            'progress' => 'nullable|integer|min:0',
            'mastered' => 'nullable|boolean',
        ]);

        $user->games()->attach($game->id, [
            'state' => $validated['status'],
            'user_score' => $validated['rating'],
            'progress' => $validated['progress'] ?? 0,
            'mastered' => $validated['mastered'] ?? false,
        ]);

        return back()->with('success', 'Game added to collection');;
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
