<?php

namespace App\Services\News;

use App\Contracts\News\RssParserService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RssParser implements RssParserService
{
    /**
     * @inheritDoc
     */
    public function parseRssFeed(string $rssUrl, int $limit = 20): array
    {
        // Cache RSS feeds for 10 minutes to reduce load
        $cacheKey = 'rss_feed.' . md5($rssUrl);
        
        $xml = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($rssUrl) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'RetroPortal/1.0 (+https://github.com/salvobee/retroportal)',
                ])
                ->timeout(10)
                ->retry(2, 500)
                ->get($rssUrl);

                if (!$response->successful()) {
                    return null;
                }

                return $response->body();
            } catch (\Throwable $e) {
                return null;
            }
        });

        if (!$xml) {
            return [];
        }

        return $this->parseXmlContent($xml, $limit);
    }

    /**
     * @inheritDoc
     */
    public function isValidRssFeed(string $rssUrl): bool
    {
        try {
            $response = Http::timeout(5)->head($rssUrl);
            return $response->successful();
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Parse XML content and extract articles.
     */
    private function parseXmlContent(string $xml, int $limit): array
    {
        $articles = [];
        
        try {
            // Disable libxml errors to handle malformed XML gracefully
            $useInternalErrors = libxml_use_internal_errors(true);
            
            $feed = simplexml_load_string($xml);
            
            if (!$feed) {
                libxml_use_internal_errors($useInternalErrors);
                return [];
            }

            // Handle RSS 2.0 format
            if (isset($feed->channel->item)) {
                foreach ($feed->channel->item as $item) {
                    $article = $this->parseRssItem($item);
                    if ($article) {
                        $articles[] = $article;
                    }
                    
                    if (count($articles) >= $limit) {
                        break;
                    }
                }
            }
            // Handle Atom format
            elseif (isset($feed->entry)) {
                foreach ($feed->entry as $entry) {
                    $article = $this->parseAtomEntry($entry);
                    if ($article) {
                        $articles[] = $article;
                    }
                    
                    if (count($articles) >= $limit) {
                        break;
                    }
                }
            }

            libxml_use_internal_errors($useInternalErrors);
            
        } catch (\Throwable $e) {
            // Log error but don't break the application
            return [];
        }

        return $articles;
    }

    /**
     * Parse RSS 2.0 item.
     */
    private function parseRssItem(\SimpleXMLElement $item): ?array
    {
        $title = trim((string) ($item->title ?? ''));
        $link = trim((string) ($item->link ?? ''));
        $description = trim((string) ($item->description ?? ''));
        $pubDate = trim((string) ($item->pubDate ?? ''));

        if (empty($title) || empty($link)) {
            return null;
        }

        // Clean up description (remove HTML tags, limit length)
        $description = $this->cleanDescription($description);
        
        // Parse publication date
        $timestamp = $pubDate ? @strtotime($pubDate) : null;

        return [
            'title' => $this->cleanTitle($title),
            'url' => $link,
            'description' => $description,
            'published_at' => $timestamp,
        ];
    }

    /**
     * Parse Atom entry.
     */
    private function parseAtomEntry(\SimpleXMLElement $entry): ?array
    {
        $title = trim((string) ($entry->title ?? ''));
        $link = '';
        $description = trim((string) ($entry->summary ?? $entry->content ?? ''));
        $published = trim((string) ($entry->published ?? $entry->updated ?? ''));

        // Extract link from Atom format
        if (isset($entry->link)) {
            if (is_array($entry->link)) {
                $link = (string) $entry->link[0]['href'];
            } else {
                $link = (string) $entry->link['href'];
            }
        }

        if (empty($title) || empty($link)) {
            return null;
        }

        // Clean up description
        $description = $this->cleanDescription($description);
        
        // Parse publication date
        $timestamp = $published ? @strtotime($published) : null;

        return [
            'title' => $this->cleanTitle($title),
            'url' => trim($link),
            'description' => $description,
            'published_at' => $timestamp,
        ];
    }

    /**
     * Clean and format article title.
     */
    private function cleanTitle(string $title): string
    {
        // Remove HTML tags
        $title = strip_tags($title);
        
        // Replace multiple whitespace with single space
        $title = preg_replace('/\s+/', ' ', $title);
        
        // Limit length for retro display
        if (strlen($title) > 150) {
            $title = substr($title, 0, 147) . '...';
        }
        
        return trim($title);
    }

    /**
     * Clean and format article description.
     */
    private function cleanDescription(string $description): ?string
    {
        if (empty($description)) {
            return null;
        }
        
        // Remove HTML tags
        $description = strip_tags($description);
        
        // Replace multiple whitespace with single space
        $description = preg_replace('/\s+/', ' ', $description);
        
        // Limit length for retro display
        if (strlen($description) > 300) {
            $description = substr($description, 0, 297) . '...';
        }
        
        $description = trim($description);
        
        return empty($description) ? null : $description;
    }
}