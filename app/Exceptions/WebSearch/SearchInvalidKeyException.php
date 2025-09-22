<?php

namespace App\Exceptions\WebSearch;

class SearchInvalidKeyException extends SearchApiException
{
    public function category(): string { return 'invalid_key'; }
}
