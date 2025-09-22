<?php

namespace App\Services\WebSearch;

use App\Contracts\WebSearch\ProgrammableSearchService;
use App\Exceptions\WebSearch\SearchApiException;
use App\Exceptions\WebSearch\SearchInvalidCxException;
use App\Exceptions\WebSearch\SearchInvalidKeyException;
use App\Exceptions\WebSearch\SearchQuotaExceededException;
use App\Exceptions\WebSearch\SearchRateLimitedException;
use App\Exceptions\WebSearch\SearchRequestDeniedException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class GoogleProgrammableSearch implements ProgrammableSearchService
{
    private string $apiKey;
    private string $cxWeb;
    private ?string $cxImg;

    public function __construct()
    {
        $this->apiKey = (string) config('services.google_cse.key', env('GOOGLE_CSE_API_KEY', ''));
        $this->cxWeb  = (string) config('services.google_cse.cx_web', env('GOOGLE_CSE_CX_WEB', ''));
        $this->cxImg  = (string) config('services.google_cse.cx_img', env('GOOGLE_CSE_CX_IMG', '')) ?: null;

        if ($this->apiKey === '' || $this->cxWeb === '') {
            throw new RuntimeException('Google CSE API key or CX (web) missing.');
        }
    }

    public function searchWeb(string $query, array $options = []): array
    {
        $query = trim($query);
        if ($query === '') {
            return $this->emptyWeb($query);
        }

        $params = $this->baseParams($query, $options);
        $params['cx'] = $this->cxWeb;
        // NIENTE searchType qui (web default)
        $response = $this->call($params);

        $items = [];
        foreach ((array) ($response['items'] ?? []) as $it) {
            $items[] = [
                'title'       => (string) ($it['title'] ?? ''),
                'snippet'     => isset($it['snippet']) ? trim((string) $it['snippet']) : null,
                'url'         => (string) ($it['link'] ?? ''),
                'display_url' => isset($it['displayLink']) ? (string) $it['displayLink'] : null,
                'source'      => $this->extractSource($it),
            ];
        }

        return [
            'type'       => 'web',
            'query'      => $query,
            'items'      => $items,
            'total'      => isset($response['searchInformation']['totalResults'])
                ? (int) $response['searchInformation']['totalResults'] : null,
            'next_start' => $this->nextStart($options, count($items)),
        ];
    }

    public function searchImages(string $query, array $options = []): array
    {
        $query = trim($query);
        if ($query === '') {
            return $this->emptyImage($query);
        }

        $params = $this->baseParams($query, $options);
        $params['searchType'] = 'image';
        $params['cx'] = $this->cxImg ?: $this->cxWeb;

        // imgType: clipart|face|lineart|news|photo|animated|stock
        if (!empty($options['imgType'])) {
            $params['imgType'] = (string) $options['imgType'];
        }

        $response = $this->call($params);

        $items = [];
        foreach ((array) ($response['items'] ?? []) as $it) {
            $image = (array) ($it['image'] ?? []);
            $items[] = [
                'title'         => (string) ($it['title'] ?? ''),
                'image_url'     => (string) ($it['link'] ?? ''),
                'context_url'   => isset($it['image']['contextLink']) ? (string) $it['image']['contextLink'] : null,
                'thumbnail_url' => isset($it['image']['thumbnailLink']) ? (string) $it['image']['thumbnailLink'] : null,
                'mime'          => isset($it['mime']) ? (string) $it['mime'] : null,
                'width'         => isset($image['width']) ? (int) $image['width'] : null,
                'height'        => isset($image['height']) ? (int) $image['height'] : null,
            ];
        }

        return [
            'type'       => 'image',
            'query'      => $query,
            'items'      => $items,
            'total'      => isset($response['searchInformation']['totalResults'])
                ? (int) $response['searchInformation']['totalResults'] : null,
            'next_start' => $this->nextStart($options, count($items)),
        ];
    }

    // -------- helpers --------

    private function baseParams(string $query, array $options): array
    {
        $num   = max(1, min((int) ($options['num']   ?? 10), 10));
        $start = max(1, min((int) ($options['start'] ?? 1), 100));

        $lr = $options['lr'] ?? $this->guessLanguageRestriction();
        $gl = $options['gl'] ?? $this->guessCountryBias();
        $safe = $options['safe'] ?? 'active'; // default prudente

        return [
            'key'   => $this->apiKey,
            'q'     => $query,
            'num'   => $num,
            'start' => $start,
            'safe'  => in_array($safe, ['off', 'active'], true) ? $safe : 'off',
            // lr: language restrict, es. "lang_it"
            // gl: country/geo bias, es. "it"
            ...( $lr ? ['lr' => $lr] : [] ),
            ...( $gl ? ['gl' => $gl] : [] ),
            // hl: language UI (puoi volerlo per snippet; non sempre influenza)
            'hl'    => app()->getLocale() ?: 'en',
        ];
    }

    private function call(array $params): array
    {
        $resp = Http::withHeaders([
            'User-Agent' => 'RetroPortal/1.0 (+retroportal)',
        ])
            ->timeout(10)
            ->retry(2, 250)
            ->get('https://www.googleapis.com/customsearch/v1', $params);

        if ($resp->ok()) {
            return (array) $resp->json();
        }

        // Proviamo a leggere la struttura d'errore di Google
        $payload = (array) $resp->json();
        $errMessage = $payload['error']['message'] ?? ('HTTP '.$resp->status());
        $reason = null;
        $first = $payload['error']['errors'][0] ?? null;
        if (is_array($first) && isset($first['reason'])) {
            $reason = $first['reason']; // es: dailyLimitExceeded, rateLimitExceeded, keyInvalid, cxInvalid, requestDenied...
        }

        // Mappa ragioni note a eccezioni specifiche
        $status = $resp->status();
        if (in_array($reason, ['dailyLimitExceeded', 'usageLimits', 'quotaExceeded'], true)) {
            throw new SearchQuotaExceededException($errMessage, $status);
        }
        if (in_array($reason, ['rateLimitExceeded', 'userRateLimitExceeded'], true) || $status === 429) {
            throw new SearchRateLimitedException($errMessage, $status);
        }
        if (in_array($reason, ['keyInvalid', 'forbidden'], true)) {
            throw new SearchInvalidKeyException($errMessage, $status);
        }
        if (in_array($reason, ['cxInvalid', 'invalid', 'badRequest'], true)) {
            // spesso “invalid” arriva con messaggi relativi al cx non abilitato / sbagliato
            throw new SearchInvalidCxException($errMessage, $status);
        }
        if (in_array($reason, ['requestDenied', 'ipRefererBlocked'], true) || $status === 403) {
            throw new SearchRequestDeniedException($errMessage, $status);
        }

        // Fallback generico
        throw new SearchApiException($errMessage, $status);
    }


    private function nextStart(array $options, int $returned): ?int
    {
        $start = max(1, (int) ($options['start'] ?? 1));
        $num   = max(1, (int) ($options['num']   ?? 10));
        return ($returned === $num) ? ($start + $num) : null;
    }

    private function emptyWeb(string $query): array
    {
        return ['type' => 'web', 'query' => $query, 'items' => [], 'total' => 0, 'next_start' => null];
    }

    private function emptyImage(string $query): array
    {
        return ['type' => 'image', 'query' => $query, 'items' => [], 'total' => 0, 'next_start' => null];
    }

    private function extractSource(array $item): ?string
    {
        $display = $item['displayLink'] ?? null;
        if (!$display) return null;
        // qualcosina di carino per uniformare
        return Str::of($display)->lower()->toString();
    }

    private function guessLanguageRestriction(): ?string
    {
        $loc = app()->getLocale();
        return match ($loc) {
            'it' => 'lang_it',
            'en' => 'lang_en',
            'fr' => 'lang_fr',
            'de' => 'lang_de',
            'es' => 'lang_es',
            default => null,
        };
    }

    private function guessCountryBias(): ?string
    {
        $loc = app()->getLocale();
        return match ($loc) {
            'it' => 'it',
            'en' => 'us', // o 'gb' se vuoi bias UK in una installazione EN
            'fr' => 'fr',
            'de' => 'de',
            'es' => 'es',
            default => null,
        };
    }
}
