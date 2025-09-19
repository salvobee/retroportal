{{-- Weather: simple GET form + placeholder --}}
@extends('layout.app')

@section('title', 'Weather')
@section('page_title', 'Weather')

@section('content')
    <form class="form-inline" action="{{ route('weather') }}" method="get">
        <table border="0" cellspacing="0" cellpadding="2">
            <tr>
                <td><label for="city"><strong>City</strong></label></td>
                <td><input id="city" type="text" name="city" value="{{ $city }}" size="30"></td>
                <td><input type="submit" value="Show"></td>
            </tr>
        </table>
    </form>

    <hr noshade size="1">

    @if(strlen($city))
        <p class="muted">Selected city: <em>{{ $city }}</em></p>
        <p>Weather data will be shown here (server integration pending).</p>
    @endif
@endsection
