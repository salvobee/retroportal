<?php

namespace App\View\Components;

use App\Support\UrlProxy;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ExternalLink extends Component
{
    public string $originalUrl;
    public string $proxiedUrl;
    public bool $isValidUrl;
    public ?string $title;
    public string $target;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $url = '',
        ?string $title = null,
        string $target = '_blank'
    ) {
        $this->originalUrl = trim($url);
        $this->title = $title;
        $this->target = $target;
        
        // Determine if URL is valid and generate proxied version
        $this->isValidUrl = UrlProxy::isHttpUrl($this->originalUrl);
        $this->proxiedUrl = $this->isValidUrl ? UrlProxy::wrap($this->originalUrl) : '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.external-link');
    }
}