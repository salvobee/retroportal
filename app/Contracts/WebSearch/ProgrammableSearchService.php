<?php

namespace App\Contracts\WebSearch;

interface ProgrammableSearchService
{
    /**
     * Web search: risultati testuali/siti.
     *
     * @param string $query
     * @param array{
     *   start?: int,          // 1..100: offset risultati (paginazione)
     *   num?: int,            // 1..10: quanti risultati
     *   lr?: string|null,     // es: "lang_it"
     *   gl?: string|null,     // es: "it" (geolocal bias)
     *   safe?: 'off'|'active' // safe search
     * } $options
     * @return array{
     *   type: 'web',
     *   query: string,
     *   items: array<int, array{
     *     title: string,
     *     snippet: string|null,
     *     url: string,
     *     display_url: string|null,
     *     source: string|null
     *   }>,
     *   total: int|null,
     *   next_start: int|null
     * }
     */
    public function searchWeb(string $query, array $options = []): array;

    /**
     * Image search: risultati immagini (con supporto "solo disegni").
     *
     * @param string $query
     * @param array{
     *   start?: int,             // 1..100
     *   num?: int,               // 1..10
     *   lr?: string|null,        // "lang_it"
     *   gl?: string|null,        // "it"
     *   safe?: 'off'|'active',   // safe search
     *   imgType?: 'clipart'|'face'|'lineart'|'news'|'photo'|'animated'|'stock'
     * } $options
     * @return array{
     *   type: 'image',
     *   query: string,
     *   items: array<int, array{
     *     title: string,
     *     image_url: string,
     *     context_url: string|null,
     *     thumbnail_url: string|null,
     *     mime: string|null,
     *     width: int|null,
     *     height: int|null
     *   }>,
     *   total: int|null,
     *   next_start: int|null
     * }
     */
    public function searchImages(string $query, array $options = []): array;
}
