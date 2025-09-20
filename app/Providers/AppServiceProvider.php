<?php

namespace App\Providers;

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
    }
}
