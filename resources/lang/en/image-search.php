<?php

return [
    'title'      => 'Image Search',
    'page_title' => 'Image Search',

    'form' => [
        'query'    => 'Query',
        'submit'   => 'Search',
        'drawings' => 'Drawings only (lineart)',
        'safe'     => 'Safe Search',
    ],

    'start_hint'      => 'Enter a query to get started.',
    'no_results_yet'  => 'No results yet.',
    'no_items'        => 'No images found.',
    'total'           => 'Total',

    'errors' => [
        'quota_exceeded' => 'You have exceeded your available request quota. Please try again later or upgrade your plan.',
        'rate_limited'   => 'You are sending too many requests. Please wait and try again.',
        'invalid_key'    => 'The API key is invalid or has been revoked.',
        'invalid_cx'     => 'The search engine ID (cx) is invalid or not enabled.',
        'request_denied' => 'Request was denied by the API. Check configuration and credentials.',
        'generic'        => 'An error occurred while searching for images.',
    ],

    'try_web_search' => 'Search the Web for this query',
];
