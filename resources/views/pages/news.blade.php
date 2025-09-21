@extends('layout.app')

@section('title', __('news.title'))
@section('page_title', __('news.page_title'))

@section('content')
    @if(empty($items))
        <p class="muted">{{ __('news.empty') }}</p>
    @else
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
            @foreach($items as $item)
                <tr valign="top">
                    <td width="5">•</td>
                    <td>
                        <x-external-link url="{{ $item['url'] }}">{{ $item['title'] }}</x-external-link>

                        @if($item['source'])
                            <br><small class="muted">{{ __('news.source') }}: {{ $item['source'] }}</small>
                        @endif

                        @if($item['published_at'])
                            <br><small class="muted">
                                {{ __('news.published_at') }}:
                                {{ \Carbon\Carbon::createFromTimestamp($item['published_at'])
                                    ->locale(app()->getLocale())
                                    ->translatedFormat('d F Y, H:i') }}
                            </small>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
