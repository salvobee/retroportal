{{--
    External Link Component
    
    Automatically wraps external URLs through the proxy while displaying the original URL.
    All logic is handled in the ExternalLink component class.
    
    Usage:
    <x-external-link url="https://example.com">Visit Example</x-external-link>
    <x-external-link url="https://example.com" title="Example Website">Example</x-external-link>
--}}

@if($isValidUrl)
    <a href="{{ $proxiedUrl }}" 
       @if($title) title="{{ $title }}" @endif
       target="{{ $target }}"
       {{ $attributes }}>{{ $slot->isEmpty() ? $originalUrl : $slot }}</a>
@else
    {{-- Fallback for invalid URLs --}}
    <span {{ $attributes }}>{{ $slot->isEmpty() ? $originalUrl : $slot }}</span>
@endif