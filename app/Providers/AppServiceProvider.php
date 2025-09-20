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

            // Ultra-compatible palettes (HTML 3.2 / <body> attributes)
            $palettes = [
                'light' => [
                    'bg'    => '#ffffff',
                    'text'  => '#000000',
                    'link'  => '#0000ff',
                    'vlink' => '#660099',
                    'alink' => '#ff0000',
                    'border'=> '#cccccc',
                    'muted' => '#333333',
                ],
                'dark' => [
                    'bg'    => '#000000',
                    'text'  => '#e6e6e6',
                    'link'  => '#9ecbff',
                    'vlink' => '#c5a3ff',
                    'alink' => '#ff7a7a',
                    'border'=> '#444444',
                    'muted' => '#aaaaaa',
                ],
            ];

            $palette = $palettes[$mode] ?? $palettes['light'];

            $view->with('theme_mode', $mode)
                ->with('theme_palette', $palette);
        });
    }
}
