<?php

namespace App\Services\Wikipedia;

use App\Contracts\WikipediaService;
use Illuminate\Support\Facades\Http;

class WikipediaApiService implements WikipediaService
{
    public function search(string $query, string $locale = 'en', int $limit = 10): array
    {
        if (trim($query) === '') {
            return [];
        }

        $endpoint = "https://{$locale}.wikipedia.org/w/api.php";

        $res = Http::withHeaders([
            'User-Agent'      => config('app.name'),
            'Accept'          => 'application/json',
            'Accept-Language' => $locale, // non obbligatorio, ma aiuta
            ])->timeout(10)
            ->retry(1, 200)
            ->get($endpoint, [
                'action'  => 'query',
                'list'    => 'search',
                'srsearch'=> $query,
                'utf8'    => 1,
                'format'  => 'json',
                'srlimit' => $limit,
            ]);

        if (!$res->ok()) {
            return [];
        }

        $data = $res->json();
        $results = $data['query']['search'] ?? [];

        return collect($results)->map(function ($item) use ($locale) {
            $title = $item['title'] ?? '';
            $pageid = $item['pageid'] ?? null;
            return [
                'title'    => $title,
                'url'      => "https://{$locale}.wikipedia.org/wiki/" . rawurlencode(str_replace(' ', '_', $title)),
                'abstract' => isset($item['snippet']) ? strip_tags($item['snippet']) : null,
                'pageid'   => $pageid,
            ];
        })->all();
    }
}
