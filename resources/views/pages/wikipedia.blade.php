@extends('layout.app')

@section('title', __('ui.menu.wikipedia'))
@section('page_title', __('ui.menu.wikipedia'))

@section('content')
    <form method="get" action="{{ route('features.wikipedia') }}">
        <input type="text" name="q" value="{{ $query }}" size="40">
        <input type="submit" value="{{ __('ui.actions.search') }}">
    </form>

    <hr noshade size="1">

    @if($query && empty($results))
        <p><em>{{ __('ui.messages.no_results') }}</em></p>
    @endif

    <ul>
        @foreach($results as $item)
            <li>
                <a href="{{ route('features.proxy', ['url' => $item['url']]) }}">
                    {{ $item['title'] }}
                </a><br>
                <small class="muted">{{ $item['abstract'] }}</small>
            </li>
        @endforeach
    </ul>
@endsection
