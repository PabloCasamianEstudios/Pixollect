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
use App\Models\Saga;

// Rutas PÚBLICAS
Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/welcome', function () {
    return Inertia::render('Welcome');
});

Route::get('/gameList', function () {
    $games = Game::with(['saga', 'genres', 'platforms', 'themes'])->get();
    $genres = Genre::all();
    $platforms = Platform::all();
    $themes = Theme::all();
    $sagas = Saga::all();

    return Inertia::render('Games', [
        'games' => $games,
        'genres' => $genres,
        'platforms' => $platforms,
        'themes' => $themes,
        'sagas' => $sagas,
    ]);
});

Route::get('/compare', function () {
    return Inertia::render('Compare');
});
Route::get('/recommend', function () {
    return Inertia::render('Recommend');
});
Route::get('/collections', function () {
    return Inertia::render('Collections');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

// Rutas protegidas
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('games', GameController::class)->except(['show']);
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::get('/games', [GameController::class, 'index'])->name('games.index');

    Route::get('/admin-panel', function () {
        return Inertia::render('AdminPanel');
    });

});


Route::get('/games/create', [GameController::class, 'create'])
    ->name('games.create')
    ->middleware(['auth', 'admin']);



// esto venía de base, no se toca por ahora
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
