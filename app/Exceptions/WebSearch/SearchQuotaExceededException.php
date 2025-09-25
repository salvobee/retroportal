<?php

namespace App\Exceptions\WebSearch;

class SearchQuotaExceededException extends SearchApiException
{
    public function category(): string { return 'quota_exceeded'; }
}
