<?php

use App\Http\Controllers\Api\GameApiController;
use Illuminate\Support\Facades\Route;


Route::get('/globalStats', [GameApiController::class, 'globalStats']);

Route::prefix('games')->group(function () {
    Route::get('/', [GameApiController::class, 'index']);
    Route::get('/search', [GameApiController::class, 'search']);
    Route::get('/{game}', [GameApiController::class, 'show']);
    Route::get('/{game}/similar', [GameApiController::class, 'similarGames']);
    Route::get('/{game}/same-saga', [GameApiController::class, 'sameSaga'])->name('games.sameSaga');
    Route::get('/games/latest', [GameApiController::class, 'latestGames']);

});

Route::post('/games/{game}/increment-achievement', [GameApiController::class, 'incrementAchievement']);
Route::get('/recommend/{userId}', [GameApiController::class, 'recommendByTags']);

