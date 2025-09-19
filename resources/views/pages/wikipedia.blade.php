{{-- Wikipedia: text-first lookup --}}
@extends('layout.app')

@section('title', 'Wikipedia')
@section('page_title', 'Wikipedia')

@section('content')
    <form class="form-inline" action="{{ route('wikipedia') }}" method="get">
        <table border="0" cellspacing="0" cellpadding="2">
            <tr>
                <td><label for="q"><strong>Topic</strong></label></td>
                <td><input id="q" type="text" name="q" value="{{ $q }}" size="40"></td>
                <td><input type="submit" value="Lookup"></td>
            </tr>
        </table>
    </form>

    <hr noshade size="1">

    @if(strlen($q))
        <p class="muted">Topic: <em>{{ $q }}</em></p>
        <p>Summary and references will appear here (server integration pending).</p>
    @endif
@endsection
