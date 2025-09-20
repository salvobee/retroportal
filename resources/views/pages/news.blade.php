@extends('layout.app')

@section('title', __('ui.pages.news'))
@section('page_title', __('ui.pages.news'))

@section('content')
    @if(empty($items))
        <p class="muted">
            {{ app()->getLocale() === 'it'
                ? 'Nessuna notizia disponibile al momento.'
                : 'No news available at the moment.' }}
        </p>
    @else
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
            @foreach($items as $item)
                <tr valign="top">
                    <td width="5">•</td>
                    <td>
                        <x-external-link url="{{ $item['url'] }}">{{ $item['title'] }}</x-external-link>
                        @if($item['source'])
                            <br><small class="muted">{{ $item['source'] }}</small>
                        @endif
                        @if($item['published_at'])
                            <br><small class="muted">
                                {{ date('Y-m-d H:i', $item['published_at']) }}
                            </small>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
