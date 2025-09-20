<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WikipediaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\WikipediaService::class,
            \App\Services\Wikipedia\WikipediaApiService::class
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
