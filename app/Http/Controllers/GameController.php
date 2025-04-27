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

            'genre_ids' => 'array',
            'genre_ids.*' => 'exists:genres,id',

            'platform_ids' => 'array',
            'platform_ids.*' => 'exists:platforms,id',

            'theme_ids' => 'array',
            'theme_ids.*' => 'exists:themes,id',

            'game_mode_ids' => 'array',
            'game_mode_ids.*' => 'exists:game_modes,id',

            'game_tag_ids' => 'array',
            'game_tag_ids.*' => 'exists:game_tags,id',
        ]);

        $game = Game::create($data);

        $game->genres()->sync($data['genre_ids'] ?? []);
        $game->platforms()->sync($data['platform_ids'] ?? []);
        $game->themes()->sync($data['theme_ids'] ?? []);
        $game->gameModes()->sync($data['game_mode_ids'] ?? []);
        $game->gameTags()->sync($data['game_tag_ids'] ?? []);


        return Inertia::location(route('games.index'));
        //return response()->json($game->load(['genres', 'platforms', 'themes', 'gameModes', 'gameTags']), 201); SI QUISIESE QUE ME DEVUELVA UN JSON CON EL JUEGO
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $platforms = Platform::all();
        $genres = Genre::all();
        $themes = Theme::all();
        $gameTags = GameTag::all();
        $gameModes = GameMode::all();
        $sagas = Saga::all();

        $game->load(['platforms', 'genres', 'themes', 'gameTags', 'gameModes', 'saga']);

        return Inertia::render('Games/Show', [
            'game' => $game,
            'platforms' => $platforms,
            'genres' => $genres,
            'themes' => $themes,
            'gameTags' => $gameTags,
            'gameModes' => $gameModes,
            'sagas' => $sagas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {

        $game->load([
            'genres',
            'platforms',
            'themes',
            'gameModes',
            'gameTags',
            'saga',
        ]);

        return Inertia::render('Games/Edit', [
            'game' => $game,
            'genres' => Genre::all(),
            'platforms' => Platform::all(),
            'themes' => Theme::all(),
            'gameModes' => GameMode::all(),
            'gameTags' => GameTag::all(),
            'sagas' => Saga::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'release_date' => 'nullable|date',
                'developer' => 'nullable|string|max:255',
                'publisher' => 'nullable|string|max:255',
                'price' => 'nullable|numeric',
                'image_url' => 'nullable|url',
                'genre_ids' => 'array',
                'genre_ids.*' => 'integer|exists:genres,id',
                'platform_ids' => 'array',
                'platform_ids.*' => 'integer|exists:platforms,id',
                'theme_ids' => 'array',
                'theme_ids.*' => 'integer|exists:themes,id',
                'game_mode_ids' => 'array',
                'game_mode_ids.*' => 'integer|exists:game_modes,id',
                'game_tag_ids' => 'array',
                'game_tag_ids.*' => 'integer|exists:game_tags,id',
                'saga_id' => 'nullable|exists:sagas,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
        }

        $game->update($validated);


        $game->genres()->sync($validated['genre_ids'] ?? []);
        $game->platforms()->sync($validated['platform_ids'] ?? []);
        $game->themes()->sync($validated['theme_ids'] ?? []);
        $game->gameModes()->sync($validated['game_mode_ids'] ?? []);
        $game->gameTags()->sync($validated['game_tag_ids'] ?? []);

        return redirect()->route('games.index')->with('success', 'Game updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Game $game)
    {
        $game->delete();
    }
}


