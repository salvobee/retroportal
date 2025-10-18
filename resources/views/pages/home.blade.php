@extends('layout.app')

@section('title', __('ui.pages.home'))
@section('page_title', __('ui.pages.home'))

@section('content')
    <p>{{ __('This portal provides modern capabilities with a retro-compatible interface.') }}</p>
    <ul>
        <li><a href="{{ route('features.search') }}">{{ __('web-search.title') }}</a></li>
        <li><a href="{{ route('features.image-search') }}">{{ __('image-search.title') }}</a> </li>
        <li><a href="{{ route('features.news.index') }}">{{ __('news.title') }}</a></li>
        <li><a href="{{ route('features.weather.form') }}">{{ __('weather.title') }}</a></li>
        <li><a href="{{ route('features.wikipedia') }}">{{ __('encyclopedia.title') }}</a></li>
        <li><a href="{{ route('chatbot.index') }}">{{ __('ai.title') }}</a></li>
    </ul>
@endsection
