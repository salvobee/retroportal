@extends('layout.app')

@section('title', __('weather.limit_title'))
@section('page_title', __('weather.limit_page_title'))

@section('content')
    <div align="center">
        <p><strong>@lang('weather.limit_reached')</strong></p>
        <p class="muted">@lang('weather.limit_hint')</p>
        <p><a href="{{ route('features.weather.form') }}">⟵ @lang('weather.back_to_search')</a></p>
    </div>
@endsection
