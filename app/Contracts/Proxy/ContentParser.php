<?php

namespace App\Contracts\Proxy;

interface ContentParser
{
    /**
     * @param string $html    Documento sorgente (UTF-8)
     * @param string $baseUrl URL effettivo del documento (dopo eventuale AMP)
     * @return array{title:string, body:string}  body: HTML 3.2-friendly
     */
    public function parse(string $html, string $baseUrl): array;
}
