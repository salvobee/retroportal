@extends('layout.error')

@section('title', $exception->getCode())
@section('page_title', 'Access Denied')

@section('content')
    <p><strong>{{ $exception->getMessage() }}</strong></p>
    <p><a href="{{ url('/') }}">Return to homepage</a></p>
@endsection
