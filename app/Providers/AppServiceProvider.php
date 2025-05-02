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


            if (!$user) {
                return [
                    'user' => null,
                    'games' => [],
                ];
            }

            return [
                'user' => $user,
                'games' => $user->games()->withPivot([
                    'state',
                    'mastered',
                    'user_score',
                    'comment',
                    'progress',
                    'achievements_unlocked',
                    'hours_played',
                    'start_date',
                    'end_date',
                ])->get(),
            ];
        });

    }
}
