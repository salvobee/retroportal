<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Search\SearchService;
use App\Services\Search\DuckDuckGoSearch;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SearchService::class, DuckDuckGoSearch::class);
    }
}
