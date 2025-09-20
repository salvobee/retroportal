<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Prefer session theme; fallback to cookie; default 'light'
            $mode = session('theme');
            if (!$mode) {
                $mode = request()->cookie('theme', 'light');
            }
            $palette = config("palettes.$mode") ?? config("palettes.light");

            $view->with('theme_mode', $mode)
                ->with('theme_palette', $palette);
        });

        RateLimiter::for('weather', function ($request) {
            // es. 60 richieste/min per IP (aggiusta a piacere)
            return [
                Limit::perMinute(60)->by($request->ip()),
                // opzionale: limite giornaliero più prudente a livello app
                Limit::perDay(2000)->by($request->ip()),
            ];
        });
    }
}
