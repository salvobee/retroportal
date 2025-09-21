<?php

namespace App\Contracts\News;

interface RssParserService
{
    /**
     * Parse RSS feed and extract articles.
     *
     * @param string $rssUrl
     * @param int $limit
     * @return array<int, array{
     *   title: string,
     *   url: string,
     *   description: string|null,
     *   published_at: int|null
     * }>
     */
    public function parseRssFeed(string $rssUrl, int $limit = 20): array;

    /**
     * Check if RSS feed is accessible and valid.
     *
     * @param string $rssUrl
     * @return bool
     */
    public function isValidRssFeed(string $rssUrl): bool;
}