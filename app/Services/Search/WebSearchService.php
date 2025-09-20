<?php

namespace App\Services\Search;

interface WebSearchService
{
    /**
     * Perform a web search and return a normalized payload suitable for legacy rendering.
     *
     * @param string $query
     * @return array{
     *   heading: string|null,
     *   abstract: string|null,
     *   abstract_url: string|null,
     *   topics: array<int, array{text: string, url: string}>
     * }
     */
    public function search(string $query): array;
}
