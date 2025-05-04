<?php

use App\Http\Controllers\Api\GameApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('games')->group(function () {
    Route::get('/', [GameApiController::class, 'index']);
    Route::get('/search', [GameApiController::class, 'search']);
    Route::get('/{game}', [GameApiController::class, 'show']);
    Route::get('/{game}/similar', [GameApiController::class, 'similarGames']);
});
