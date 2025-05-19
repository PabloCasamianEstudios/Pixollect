<?php

use App\Models\Game;
use App\Models\Saga;
use Inertia\Inertia;
use App\Models\Genre;
use App\Models\Theme;
use App\Models\Platform;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserGameController;
use App\Http\Controllers\UserExportController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
Route::get('/collections', [UserController::class, 'collections'])->name('collections');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// USERS

Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/user/{user}/counts', [UserController::class, 'getUserCounts']);
Route::get('/user/{user}/stats', [UserController::class, 'getUserStats']);
Route::get('/user/{user}/games', [UserController::class, 'games'])->name('user.games');
Route::get('/user/{user}/achievements', [UserController::class, 'achievements']);



Route::post('/user/{user}/avatar', [UserController::class, 'updateAvatar'])
    ->middleware('auth')
    ->name('user.avatar.update');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// user / jueguitos en COLECCIÓN
Route::get('/user/{id}/games', [UserGameController::class, 'getUserGames']);

Route::post('/games/{game}/add', [UserGameController::class, 'store'])->middleware('auth');

Route::delete('/games/{game}/remove', [UserGameController::class, 'destroy'])
    ->middleware('auth')
    ->name('games.remove');

Route::put('/games/{game}/update', [UserGameController::class, 'update'])
    ->middleware('auth')
    ->name('games.update');

 Route::middleware('auth')->group(function () {
    Route::get('/user/{user:name}/settings', [UserController::class, 'editSettings'])->name('user.settings');
    Route::patch('/user/{user:name}/settings', [UserController::class, 'updateSettings']);
});

// EXPORTAR CSV

Route::get('/user/{user:name}/games/export/csv', [UserExportController::class, 'exportCsv'])->middleware('auth');


// Jueguitos
Route::get('/games/create', function () {
    return Inertia::render('Games/Create', [
        'genres' => \App\Models\Genre::all(),
        'platforms' => \App\Models\Platform::all(),
        'themes' => \App\Models\Theme::all(),
        'gameModes' => \App\Models\GameMode::all(),
        'gameTags' => \App\Models\GameTag::all(),
        'sagas' => \App\Models\Saga::all()
    ]);
})->middleware(['auth', 'verified'])->name('createGame');

Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

// Rutas protegidas
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('games', GameController::class)->except(['show']);
    Route::get('/games', [GameController::class, 'index'])->name('games.index');

    Route::get('/admin-panel', function () {
        return Inertia::render('AdminPanel');
    });

});


Route::get('/games/create', [GameController::class, 'create'])
    ->name('games.create')
    ->middleware(['auth', 'admin']);

    // sagas



// esto venía de base, no se toca por ahora
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
