@extends('layout.app')

@section('title', __('weather.title'))
@section('page_title', __('weather.title'))

@section('content')
    <div align="center">
        <form class="form-inline" action="{{ route('features.weather.search') }}" method="get">
            <table border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td><label for="city"><strong>{{ __('weather.city') }}</strong></label></td>
                    <td><input id="city" type="text" name="q" value="{{ $city }}" size="30"></td>
                    <td><input type="submit" value="{{ __('weather.search') }}"></td>
                </tr>
            </table>
        </form>

        <hr noshade size="1">

        @if(!empty($error))
            <p style="color:#b00;"><strong>{{ $error }}</strong></p>
            <hr noshade size="1">
        @endif

        <p class="muted">@lang('weather.hint_search')</p>
    </div>
@endsection
