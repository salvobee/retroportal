<?php

namespace App\Exceptions\WebSearch;

class SearchRequestDeniedException extends SearchApiException
{
    public function category(): string { return 'request_denied'; }
}
