<?php

namespace App\Providers;

use App\Contracts\News\NewsService;
use App\Services\News\GoogleNewsRssService;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind the interface to the Google News RSS implementation
        $this->app->bind(NewsService::class, GoogleNewsRssService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
