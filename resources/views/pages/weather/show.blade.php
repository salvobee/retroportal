@extends('layout.app')

@section('title', __('weather.title'))
@section('page_title', __('weather.title'))

@section('content')
    @php
        $p = $place;
        $w = $data['weather'][0] ?? null;
        $main = $data['main'] ?? [];
        $wind = $data['wind'] ?? [];
    @endphp

    <div align="center">
        <p class="muted">
            @lang('weather.location'):
            <strong>{{ $p['name'] }}</strong>
            @if($p['state']) ({{ $p['state'] }}) @endif
            @if($p['country']) – {{ $p['country'] }} @endif
        </p>

        @if(!$w)
            <p>@lang('weather.unavailable')</p>
        @else
            <table border="0" cellspacing="0" cellpadding="4">
                <tr><td>@lang('weather.condition')</td><td>{{ ucfirst($w['description'] ?? '') }}</td></tr>
                <tr><td>@lang('weather.temperature')</td><td>{{ round($main['temp'] ?? 0) }}°</td></tr>
                <tr><td>@lang('weather.feels_like')</td><td>{{ round($main['feels_like'] ?? 0) }}°</td></tr>
                <tr><td>@lang('weather.humidity')</td><td>{{ $main['humidity'] ?? '-' }}%</td></tr>
                <tr><td>@lang('weather.wind')</td><td>{{ $wind['speed'] ?? '-' }} m/s</td></tr>
            </table>
        @endif

        <p><a href="{{ route('features.weather.form') }}">⟵ @lang('weather.search_another')</a></p>
    </div>
@endsection
