<?php

return [
    'parsers' => [
        // 'wikipedia.org' => \App\Services\Proxy\Parsers\WikipediaContentParser::class,
    ],

    'whitelist' => [
        'wikipedia.org',
    ],

    'whitelist_only' => env('RETRO_PROXY_WHITELIST_ONLY', true),
];
