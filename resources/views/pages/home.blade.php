{{-- resources/views/pages/home.blade.php --}}
@extends('layout.app')

@section('title', __('ui.pages.home'))
@section('page_title', __('ui.pages.home'))

@section('content')
    <p>{{ __('This portal provides modern capabilities with a retro-compatible interface.') }}</p>
    <ul>
        <li><a href="{{ route('features.search') }}">{{ __('ui.menu.search') }}</a></li>
        <li><a href="{{ route('features.news') }}">{{ __('ui.menu.news') }}</a></li>
        <li><a href="{{ route('features.weather') }}">{{ __('ui.menu.weather') }}</a></li>
        <li><a href="{{ route('features.wikipedia') }}">{{ __('ui.menu.wikipedia') }}</a></li>
    </ul>
@endsection
