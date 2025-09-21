@extends('layout.error')

@section('title', '403 Forbidden')
@section('page_title', 'Access Denied')

@section('content')
    <p><strong>You do not have permission to access this page.</strong></p>
    <p><a href="{{ url('/') }}">Return to homepage</a></p>
@endsection
