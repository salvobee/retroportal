@extends('layout.error')

@section('title', '500 Server Error')
@section('page_title', 'Server Error')

@section('content')
    <p><strong>An unexpected error occurred on the server.</strong></p>
    <p>Please try again later.</p>
    <p><a href="{{ url('/') }}">Return to homepage</a></p>
@endsection
