<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EncyclopediaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\Research\EncyclopediaService::class,
            \App\Services\Research\WikipediaApiService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
