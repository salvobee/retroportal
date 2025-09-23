@extends('layout.app')

@section('title', __('weather.title'))
@section('page_title', __('weather.title'))

@section('content')
    <div align="center">
        @if(!empty($error))
            <p style="color:#b00;"><strong>{{ $error }}</strong></p>
        @elseif(count($results))
            <p>{{ __('weather.results_for') }} <em>{{ $q }}</em></p>
            <ul>
                @foreach($results as $loc)
                    <li>
                        <a href="{{ route('features.weather.show', [
                            'lat' => $loc['lat'],
                            'lon' => $loc['lon'],
                            'name' => $loc['name'] ?? '',
                            'state' => $loc['state'] ?? '',
                            'country' => $loc['country'] ?? '',
                        ]) }}">
                            {{ $loc['name'] }} ({{ $loc['state'] ?? '' }} {{ $loc['country'] ?? '' }})
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>{{ __('weather.no_results') }}</p>
        @endif

        <p><a href="{{ route('features.weather.form') }}">⟵ @lang('weather.search_another')</a></p>
    </div>
@endsection
