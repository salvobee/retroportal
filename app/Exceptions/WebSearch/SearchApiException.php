<?php

namespace App\Exceptions\WebSearch;
use Exception;

class SearchApiException extends Exception
{
    public function __construct(string $message = 'Search API error', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function category(): string
    {
        return 'generic';
    }

    public function detail(): ?string
    {
        return $this->getMessage();
    }
}
