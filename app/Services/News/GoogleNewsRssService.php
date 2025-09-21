<?php

namespace App\Services\News;

use App\Contracts\News\NewsService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GoogleNewsRssService implements NewsService
{
    /**
     * Map app locales to Google News RSS localization parameters.
     * 'hl' = UI language, 'gl' = country, 'ceid' = Country:Lang
     */
    private const LOCALE_MAP = [
        'it' => ['hl' => 'it', 'gl' => 'IT', 'ceid' => 'IT:it'],
        'en' => ['hl' => 'en', 'gl' => 'US', 'ceid' => 'US:en'],
        'fr' => ['hl' => 'fr', 'gl' => 'FR', 'ceid' => 'FR:fr'],
        'de' => ['hl' => 'de', 'gl' => 'DE', 'ceid' => 'DE:de'],
        'es' => ['hl' => 'es', 'gl' => 'ES', 'ceid' => 'ES:es'],
    ];

    /**
     * @inheritDoc
     */
    public function latest(string $locale = 'en', int $limit = 30): array
    {
        $params = self::LOCALE_MAP[$locale] ?? self::LOCALE_MAP['en'];

        // Build the RSS endpoint
        $url = 'https://news.google.com/rss';
        $query = [
            'hl'   => $params['hl'],
            'gl'   => $params['gl'],
            'ceid' => $params['ceid'],
        ];

        // Cache to reduce latency and avoid rate issues (5 minutes)
        $cacheKey = 'news.google.' . implode('.', $query);
        $xml = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($url, $query) {
            $res = Http::withHeaders([
                // Explicit UA can help some CDNs; not strictly required
                'User-Agent' => 'RetroPortal/1.0 (+https://example.com)',
            ])
                ->timeout(8)
                ->retry(1, 200)
                ->get($url, $query);

            if (!$res->ok()) {
                return null;
            }
            return $res->body();
        });

        if (!$xml) {
            return [];
        }

        // Parse RSS safely (no namespaces needed)
        $items = [];
        try {
            $feed = @simplexml_load_string($xml);
            if (!$feed || !isset($feed->channel->item)) {
                return [];
            }

            foreach ($feed->channel->item as $item) {
                $title = trim((string) ($item->title ?? ''));
                $link  = trim((string) ($item->link ?? ''));
                $pub   = trim((string) ($item->pubDate ?? ''));

                // Extract source when available (often in <source> tag)
                $source = null;
                if (isset($item->source)) {
                    $source = trim((string) $item->source);
                }

                $timestamp = $pub ? @strtotime($pub) : null;

                if ($title && $link) {
                    $items[] = [
                        'title'        => $this->truncate($this->singleLine($title), 200),
                        'url'          => $link,
                        'source'       => $source ?: null,
                        'published_at' => $timestamp ?: null,
                    ];
                }

                if (count($items) >= $limit) {
                    break;
                }
            }
        } catch (\Throwable) {
            return [];
        }

        return $items;
    }

    /** Keep legacy layout stable: strip hard newlines. */
    private function singleLine(string $text): string
    {
        return str_replace(["\r\n", "\n", "\r"], ' ', $text);
    }

    /** Simple truncation to avoid overly long lines in legacy UI. */
    private function truncate(string $text, int $limit): string
    {
        return (strlen($text) > $limit) ? (substr($text, 0, $limit - 1) . '…') : $text;
    }
}
