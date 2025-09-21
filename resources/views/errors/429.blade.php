@extends('layout.error')

@section('title', '429 Too Many Requests')
@section('page_title', 'Too Many Requests')

@section('content')
    <p><strong>You have made too many requests in a short time.</strong></p>
    <p>Please wait before trying again.</p>
    <p><a href="{{ url('/') }}">Return to homepage</a></p>
@endsection
