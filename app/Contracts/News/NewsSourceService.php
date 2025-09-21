<?php

namespace App\Contracts\News;

interface NewsSourceService
{
    /**
     * Get available news sources grouped by category and locale.
     *
     * @param string $locale App locale (e.g., 'en', 'it')
     * @return array<string, array<int, array{
     *   id: string,
     *   name: string,
     *   description: string,
     *   url: string,
     *   rss_url: string|null,
     *   country: string|null,
     *   language: string
     * }>>
     */
    public function getSourcesByCategory(string $locale = 'en'): array;

    /**
     * Get a specific news source by ID.
     *
     * @param string $sourceId
     * @return array{
     *   id: string,
     *   name: string,
     *   description: string,
     *   url: string,
     *   rss_url: string|null,
     *   country: string|null,
     *   language: string,
     *   category: string
     * }|null
     */
    public function getSource(string $sourceId): ?array;

    /**
     * Fetch latest articles from a specific news source.
     *
     * @param string $sourceId
     * @param int $limit
     * @return array<int, array{
     *   title: string,
     *   url: string,
     *   description: string|null,
     *   published_at: int|null,
     *   source_name: string
     * }>
     */
    public function getArticles(string $sourceId, int $limit = 20): array;
}