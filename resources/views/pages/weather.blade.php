{{-- Weather: simple GET form + weather data display --}}
@extends('layout.app')

@section('title', 'Weather')
@section('page_title', 'Weather')

@section('content')
    <form class="form-inline" action="{{ route('features.weather') }}" method="get">
        <table border="0" cellspacing="0" cellpadding="2">
            <tr>
                <td><label for="city"><strong>City</strong></label></td>
                <td><input id="city" type="text" name="city" value="{{ $city }}" size="30"></td>
                <td><input type="submit" value="Show"></td>
            </tr>
        </table>
    </form>

    <hr noshade size="1">

    @if($weather)
        @if(isset($weather['error']))
            <p class="muted">
                <strong>{{ $weather['city'] }}</strong>: {{ $weather['error'] }}
            </p>
        @else
            <table border="0" cellspacing="0" cellpadding="4" width="100%">
                <tr>
                    <td colspan="2">
                        <strong>{{ $weather['city'] }}@if($weather['country']), {{ $weather['country'] }}@endif</strong>
                    </td>
                </tr>
                <tr>
                    <td width="120"><strong>Temperature:</strong></td>
                    <td>{{ $weather['temperature'] }}°C</td>
                </tr>
                <tr>
                    <td><strong>Conditions:</strong></td>
                    <td>{{ $weather['description'] }}</td>
                </tr>
                <tr>
                    <td><strong>Humidity:</strong></td>
                    <td>{{ $weather['humidity'] }}%</td>
                </tr>
                <tr>
                    <td><strong>Pressure:</strong></td>
                    <td>{{ $weather['pressure'] }} hPa</td>
                </tr>
                <tr>
                    <td><strong>Wind Speed:</strong></td>
                    <td>{{ $weather['wind_speed'] }} m/s</td>
                </tr>
            </table>
        @endif
    @elseif(strlen($city))
        <p class="muted">Enter a city name to get current weather information.</p>
    @endif

    @if(!$city)
        <p class="muted">
            Enter a city name above to get current weather conditions.<br>
            <small>Examples: London, Rome, New York, Tokyo</small>
        </p>
        
        @if(empty(config('services.openweathermap.key')))
            <hr noshade size="1">
            <p class="muted">
                <strong>Note:</strong> Currently using demo data. 
                To get real weather data, configure <code>OPENWEATHERMAP_API_KEY</code> 
                in your .env file with a free API key from 
                <a href="https://openweathermap.org/api" target="_blank">OpenWeatherMap</a>.
            </p>
        @endif
    @endif
@endsection
