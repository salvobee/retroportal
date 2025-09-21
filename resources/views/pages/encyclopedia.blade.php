@extends('layout.app')

@section('title', __('encyclopedia.title'))
@section('page_title', __('encyclopedia.title'))

@section('content')
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <form method="get" action="{{ route('features.wikipedia') }}">
                    <label for="q"><strong>{{ __('encyclopedia.labels.query') }}</strong></label>
                    <input id="q" type="text" name="q" value="{{ $query }}" size="40">
                    <input type="submit" value="{{ __('encyclopedia.actions.search') }}">
                </form>
            </td>
        </tr>
    </table>

    <hr noshade size="1">

    @if($query)
        {{-- Fonte utilizzata --}}
        <p class="muted">
            {{ __('encyclopedia.labels.source') }}: <strong>{{ $source }}</strong>
        </p>

        @if(empty($results))
            <p><em>{{ __('encyclopedia.messages.no_results') }}</em></p>
        @else
            <ul>
                @foreach($results as $item)
                    <li>
                        <a href="{{ route('features.proxy', ['url' => $item['url']]) }}">
                            {{ $item['title'] }}
                        </a><br>
                        @if(!empty($item['abstract']))
                            <small class="muted">{{ $item['abstract'] }}</small>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    @else
        {{-- Suggerimento iniziale come in search --}}
        <p align="center" class="muted">{{ __('encyclopedia.messages.start_hint') }}</p>
    @endif
@endsection
