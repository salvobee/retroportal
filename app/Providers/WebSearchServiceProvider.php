<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Search\WebSearchService;
use App\Services\Search\DuckDuckGoWebSearch;

class WebSearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(WebSearchService::class, DuckDuckGoWebSearch::class);
    }
}
