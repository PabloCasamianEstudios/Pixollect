<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Vite::prefetch(concurrency: 3);
        Inertia::share('auth', function () {
            $user = Auth::user();

            return $user ? [
                'user' => $user,
                'games' => $user->games()->pluck('games.id')->toArray(),
            ] : null;
        });

    }
}
