@extends('layout.app')

@section('title', __('weather.title'))
@section('page_title', __('weather.title'))

@section('content')
    <div align="center">
        <form action="{{ route('features.weather.search') }}" method="get">
            <table border="0" cellspacing="0" cellpadding="4">
                <tr>
                    <td><label for="q"><strong>@lang('weather.city')</strong></label></td>
                    <td><input id="q" type="text" name="q" size="30" autocomplete="off"></td>
                    <td><input type="submit" value="@lang('weather.search')"></td>
                </tr>
            </table>
        </form>

        <hr noshade size="1">

        <p class="muted">@lang('weather.hint_search')</p>
    </div>
@endsection
