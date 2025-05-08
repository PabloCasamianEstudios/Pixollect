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
        // IMPORTANTE!!! cuando deje de procrastinar, tengo q meter likes y reviews de cada user.
        $validated = $request->validate([
            'status' => 'required|string',
            'rating' => 'nullable|numeric|min:0|max:10',
            'achievements_unlocked' => 'nullable|integer|min:0|max:' . $game->achievements,
            'hours_played' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date|after_or_equal:' . $game->release_date,
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'mastered' => 'nullable|boolean',
            // 'liked' => 'nullable|boolean',
            // 'review' => 'nullable|string|max:1000',
        ]);


        $user->games()->attach($game->id, [
            'state' => $validated['status'],
            'user_score' => $validated['rating'] ?? null,
            'progress' => $validated['achievements_unlocked'] ?? 0,
            'hours_played' => $validated['hours_played'] ?? 0,
            'mastered' => $validated['mastered'] ?? false,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            // 'liked' => $validated['liked'] ?? false,
            // 'review' => $validated['review'] ?? null,
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
