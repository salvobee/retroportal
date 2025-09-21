<?php

namespace App\Providers;

use App\Contracts\News\NewsService;
use App\Contracts\News\NewsSourceService;
use App\Contracts\News\RssParserService;
use App\Services\News\GoogleNewsRssService;
use App\Services\News\NewsSourceManager;
use App\Services\News\RssParser;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register RSS parser service
        $this->app->bind(RssParserService::class, RssParser::class);
        
        // Register news source manager
        $this->app->bind(NewsSourceService::class, NewsSourceManager::class);
        
        // Keep legacy news service for backward compatibility
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
