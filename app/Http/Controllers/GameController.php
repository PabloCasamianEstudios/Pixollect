<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Saga;
use Inertia\Inertia;
use App\Models\Genre;
use App\Models\Theme;
use App\Models\GameTag;
use App\Models\GameMode;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

         $games = Game::all();
         $genres = Genre::all();
         $platforms = Platform::all();
         $themes = Theme::all();

        return Inertia::render('Games/Index', [
            'games' => $games,
            'genres' => $genres,
            'platforms' => $platforms,
            'themes' => $themes,
            'successMessage' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Games/Create', [
            'genres' => \App\Models\Genre::all(),
            'platforms' => \App\Models\Platform::all(),
            'themes' => \App\Models\Theme::all(),
            'gameModes' => \App\Models\GameMode::all(),
            'gameTags' => \App\Models\GameTag::all(),
            'sagas' => \App\Models\Saga::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'nullable|date',
            'developer' => 'nullable|string',
            'publisher' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image_url' => 'nullable|string',
            'saga_id' => 'nullable|exists:sagas,id',

            'genres' => 'array',
            'genres.*' => 'exists:genres,id',

            'platforms' => 'array',
            'platforms.*' => 'exists:platforms,id',

            'themes' => 'array',
            'themes.*' => 'exists:themes,id',

            'game_modes' => 'array',
            'game_modes.*' => 'exists:game_modes,id',

            'game_tags' => 'array',
            'game_tags.*' => 'exists:game_tags,id',
        ]);

        $game = Game::create($data);

        $game->genres()->sync($data['genres'] ?? []);
        $game->platforms()->sync($data['platforms'] ?? []);
        $game->themes()->sync($data['themes'] ?? []);
        $game->gameModes()->sync($data['game_modes'] ?? []);
        $game->gameTags()->sync($data['game_tags'] ?? []);

        return Inertia::location(route('games.index'));
        //return response()->json($game->load(['genres', 'platforms', 'themes', 'gameModes', 'gameTags']), 201); SI QUISIESE QUE ME DEVUELVA UN JSON CON EL JUEGO
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Game $game)
    {
        $game->delete();
    }
}


