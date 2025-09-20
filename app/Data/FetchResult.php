<?php

namespace App\Data;

final readonly class FetchResult
{
    public function __construct(
        public string $finalUrl,
        public string $html,
    )
    {
    }
}
