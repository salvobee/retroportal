@extends('layout.app')

@section('title', __('ai.limit_title'))
@section('page_title', __('ai.limit_title'))

@section('content')
    <div align="center">
        <p style="color:#b00;">
            {{ __('ai.error.limit_message') }}
        </p>
        <p class="muted">{!! __('ai.error.limit_suggestion', ['url' => route('dashboard.profile')]) !!}</p>

        <p><a href="{{ route('chatbot.index') }}">⟵ @lang('ai.back_to_conversation')</a></p>
    </div>
@endsection
