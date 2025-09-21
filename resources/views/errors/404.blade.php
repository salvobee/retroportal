@extends('layout.error')

@section('title', '404 Not Found')
@section('page_title', 'Page Not Found')

@section('content')
    <p><strong>The page you requested could not be found.</strong></p>
    <p><a href="{{ url('/') }}">Return to homepage</a></p>
@endsection
