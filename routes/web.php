<?php

use App\Models\Game;
use Inertia\Inertia;
use App\Models\Genre;
use App\Models\Theme;
use App\Models\Platform;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;


// Route::get('/', function () {
//     return Inertia::render('Home', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Rutas base
Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/welcome', function () {
    return Inertia::render('Welcome');
});

Route::get('/gameList', function () {
    $games = Game::all();
    $genres = Genre::all();
    $platforms = Platform::all();
    $themes = Theme::all();

    return Inertia::render('Games', [
        'games' => $games,
        'genres' => $genres,
        'platforms' => $platforms,
        'themes' => $themes,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Modelos
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('games', GameController::class);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
});




// esto venía de base, no se toca por ahora
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
