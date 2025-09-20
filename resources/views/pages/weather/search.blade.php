@extends('layout.app')

@section('title', __('weather.choose_city'))
@section('page_title', __('weather.choose_city'))

@section('content')
    <div align="center">
        <p>@lang('weather.query'): <em>{{ $q }}</em></p>

        @if(empty($results))
            <p>@lang('weather.no_results')</p>
        @else
            <ul style="display:inline-block; text-align:left;">
                @foreach($results as $c)
                    @php
                        $name = $c['name'] ?? 'Unknown';
                        $state = $c['state'] ?? '';
                        $country = $c['country'] ?? '';
                    @endphp
                    <li>
                        <a href="{{ route('features.weather.show', [
                        'lat' => $c['lat'], 'lon' => $c['lon'],
                        'name' => $name, 'state' => $state, 'country' => $country
                    ]) }}">
                            {{ $name }}@if($state), {{ $state }}@endif @if($country) ({{ $country }}) @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <p><a href="{{ route('features.weather.form') }}">⟵ @lang('weather.new_search')</a></p>
    </div>
@endsection
