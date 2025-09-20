<?php

namespace App\Services\News;

interface NewsService
{
    /**
     * Fetch a localized list of news items from a free source.
     *
     * @param string $locale App locale (e.g., 'en', 'it').
     * @param int    $limit  Max items to return.
     * @return array<int, array{
     *   title: string,
     *   url: string,
     *   source: string|null,
     *   published_at: int|null
     * }>
     */
    public function latest(string $locale = 'en', int $limit = 30): array;
}
