<?php

namespace App\Exceptions\WebSearch;

class SearchInvalidCxException extends SearchApiException
{
    public function category(): string { return 'invalid_cx'; }
}
