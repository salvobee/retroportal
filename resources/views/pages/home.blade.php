{{-- resources/views/pages/home.blade.php --}}
@extends('layout.app')

@section('title', __('ui.pages.home'))
@section('page_title', __('ui.pages.home'))

@section('content')
    <p>{{ __('This portal provides modern capabilities with a retro-compatible interface.') }}</p>
{{--    <ul>--}}
{{--        <li><a href="{{ route('search') }}">{{ __('ui.menu.search') }}</a></li>--}}
{{--        <li><a href="{{ route('news') }}">{{ __('ui.menu.news') }}</a></li>--}}
{{--        <li><a href="{{ route('weather') }}">{{ __('ui.menu.weather') }}</a></li>--}}
{{--        <li><a href="{{ route('wikipedia') }}">{{ __('ui.menu.wikipedia') }}</a></li>--}}
{{--    </ul>--}}
@endsection
