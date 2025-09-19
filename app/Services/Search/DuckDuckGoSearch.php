<?php

namespace App\Services\Search;

use Illuminate\Support\Facades\Http;

class DuckDuckGoSearch implements SearchService
{
    /**
     * Query DuckDuckGo Instant Answer API.
     * Docs: https://duckduckgo.com/api
     *
     * We intentionally request plain JSON with no redirects and no HTML.
     */
    public function search(string $query): array
    {
        $query = trim($query);

        if ($query === '') {
            return [
                'heading'      => null,
                'abstract'     => null,
                'abstract_url' => null,
                'topics'       => [],
            ];
        }

        // Map Laravel locale to DuckDuckGo kl parameter
        $locale = app()->getLocale() ?? 'en';
        $kl = match ($locale) {
            'it'     => 'it-it',
            'en'     => 'us-en',
            'fr'     => 'fr-fr',
            'de'     => 'de-de',
            'es'     => 'es-es',
            default  => 'us-en',
        };

        $response = Http::withHeaders([
            'User-Agent' => 'RetroPortal/1.0 (+https://example.com)',
        ])
            ->timeout(8)
            ->retry(1, 200)
            ->get('https://api.duckduckgo.com/', [
                'q'            => $query,
                'format'       => 'json',
                'no_html'      => 1,
                'no_redirect'  => 1,
                'skip_disambig'=> 0,
                'kl'           => $kl,     // region / language
                'hl'           => $locale, // UI language
            ]);

        if (!$response->ok()) {
            return [
                'heading'      => null,
                'abstract'     => null,
                'abstract_url' => null,
                'topics'       => [],
            ];
        }

        $json = $response->json();


        // Normalize top-level abstract data
        $heading      = self::nullableString($json['Heading']       ?? null);
        $abstract     = self::nullableString($json['AbstractText']  ?? null);
        $abstractUrl  = self::nullableString($json['AbstractURL']   ?? null);

        // Collect related topics (disambiguation, categories, etc.)
        $topics = [];
        foreach (($json['RelatedTopics'] ?? []) as $item) {
            // Items may be nested: sometimes a "Topic" group with its own "Topics"
            if (isset($item['Text'], $item['FirstURL'])) {
                $topics[] = [
                    'text' => self::truncate(self::stripNewlines((string)$item['Text']), 220),
                    'url'  => (string)$item['FirstURL'],
                ];
            } elseif (isset($item['Topics']) && is_array($item['Topics'])) {
                foreach ($item['Topics'] as $sub) {
                    if (isset($sub['Text'], $sub['FirstURL'])) {
                        $topics[] = [
                            'text' => self::truncate(self::stripNewlines((string)$sub['Text']), 220),
                            'url'  => (string)$sub['FirstURL'],
                        ];
                    }
                }
            }
            // Hard limit to keep legacy pages compact
            if (count($topics) >= 25) {
                break;
            }
        }

        return [
            'heading'      => $heading ?: null,
            'abstract'     => $abstract ?: null,
            'abstract_url' => $abstractUrl ?: null,
            'topics'       => $topics,
        ];
    }

    /** Ensure scalar to string, trimming whitespace. */
    private static function nullableString($value): ?string
    {
        if (!is_string($value)) return null;
        $v = trim($value);
        return $v === '' ? null : $v;
    }

    /** Replace hard newlines to keep table layout stable on ancient browsers. */
    private static function stripNewlines(string $text): string
    {
        return str_replace(["\r\n", "\n", "\r"], ' ', $text);
    }

    /** Simple truncation helper to avoid overly long lines on legacy UIs. */
    private static function truncate(string $text, int $limit): string
    {
        return (strlen($text) > $limit) ? (substr($text, 0, $limit - 1) . '…') : $text;
    }
}
