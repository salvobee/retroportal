<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'openweather' => [
        'key'   => env('OPENWEATHER_KEY'),
        'lang'  => env('OPENWEATHER_LANG', 'en'),
        'units' => env('OPENWEATHER_UNITS', 'metric'),
        'base'  => 'https://api.openweathermap.org',
    ],

    'openai' => [
        'key' => env('OPENAI_KEY'),
        'model' => env('OPENAI_MODEL', 'gpt-5'),
        'base_uri' => env('OPENAI_BASE', 'https://api.openai.com/v1'),
    ],

    'google_cse' => [
        'key'    => env('GOOGLE_CSE_API_KEY'),
        'cx_web' => env('GOOGLE_CSE_CX_WEB'),
        'cx_img' => env('GOOGLE_CSE_CX_IMG'), // opzionale
    ],
];
