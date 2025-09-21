@extends('layout.app')

@section('title', __('ai.limit_title'))
@section('page_title', __('ai.limit_title'))

@section('content')
    <div align="center">
        <p style="color:#b00;">
            {{ __('ai.error.limit_message') }}
        </p>
        <p>
            {{ __('ai.error.limit_suggestion') }}
        </p>
    </div>
@endsection
