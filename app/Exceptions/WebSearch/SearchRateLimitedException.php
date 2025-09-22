<?php

namespace App\Exceptions\WebSearch;

class SearchRateLimitedException extends SearchApiException
{
    public function category(): string { return 'rate_limited'; }
}
