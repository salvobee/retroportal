<?php

namespace App\Contracts;

interface WikipediaService
{
    /**
     * Search Wikipedia entries for a given query and locale.
     *
     * @param string $query   Search keywords.
     * @param string $locale  Wikipedia language (e.g., 'en', 'it').
     * @param int    $limit   Max results.
     * @return array<int, array{
     *   title: string,
     *   url: string,
     *   abstract: string|null,
     *   pageid: int|null
     * }>
     */
    public function search(string $query, string $locale = 'en', int $limit = 10): array;
}
