<?php

namespace App\Providers;

use App\Contracts\WebSearchService;
use App\Services\Search\DuckDuckGoWebSearch;
use Illuminate\Support\ServiceProvider;

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
