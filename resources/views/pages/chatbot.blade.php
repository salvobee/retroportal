@extends('layout.app')

@section('title', __('ai.title'))
@section('page_title', __('ai.page_title'))

@section('content')
    <center>
        <form action="{{ route('chatbot.send') }}" method="post">
            @csrf
            <table border="0" cellspacing="4" cellpadding="2">
                <tr>
                    <td><label for="message"><strong>{{ __('ai.message') }}</strong></label></td>
                    <td><input id="message" type="text" name="message" size="60" value=""></td>
                    <td><input type="submit" value="{{ __('ai.send') }}"></td>
                </tr>
            </table>
            @error('message')
            <p style="color:#b00;">{{ $message }}</p>
            @enderror
        </form>
    </center>

    <hr noshade size="1">

    @if(!empty($error))
        <p style="color:#b00;"><strong>{{ $error }}</strong></p>
        <hr noshade size="1">
    @endif

    <div>
        @forelse($history as $entry)
            @if($entry['role'] === 'user')
                <p><strong>{{ __('ai.you') }}:</strong> {{ $entry['content'] }}</p>
            @else
                <p><strong>{{ __('ai.ai') }}:</strong> {{ $entry['content'] }}</p>
            @endif
        @empty
            <p class="muted">{{ __('ai.start_hint') }}</p>
        @endforelse
    </div>

    <hr noshade size="1">
    <form action="{{ route('chatbot.clear') }}" method="post">
        @csrf
        <input type="submit" value="{{ __('ai.clear') }}">
    </form>
@endsection
