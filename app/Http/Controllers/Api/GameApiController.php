<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameApiController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::with(['genres', 'platforms', 'tags'])->findOrFail($id);
        return response()->json($game);
    }

    // Buscar juego
    public function search(Request $request)
    {

    }

    // Recomendador de juegos para el usuario
    public function recommendByTags($userId)
    {

    }

    // Comparador de jeugos para el usuario
    public function compare(Request $request)
    {
    }

}
