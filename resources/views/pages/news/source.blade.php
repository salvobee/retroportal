{{-- News Articles: Articles from a specific source --}}
@extends('layout.app')

@section('title', $source['name'] . ' - ' . __('news.title'))
@section('page_title', $source['name'])

@section('breadcrumbs')
    <a href="{{ route('features.news.index') }}">{{ __('news.title') }}</a> &gt; {{ $source['name'] }}
@endsection

@section('content')
    @if($source['description'])
        <p class="muted">{{ $source['description'] }}</p>
        <hr noshade size="1">
    @endif

    @if(empty($articles))
        <p class="muted">{{ __('news.no_articles') }}</p>

        <p>
            <a href="{{ route('features.news.index') }}">&laquo; {{ __('news.back_to_sources') }}</a>
        </p>
    @else
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
            @foreach($articles as $article)
                <tr valign="top">
                    <td width="5">•</td>
                    <td>
                        <strong>
                            <x-external-link url="{{ $article['url'] }}">{{ $article['title'] }}</x-external-link>
                        </strong>

                        @if($article['description'])
                            <br><span class="muted">{{ $article['description'] }}</span>
                        @endif

                        @if($article['published_at'])
                            <br><small class="muted">
                                {{ __('news.published_at') }}:
                                {{ \Carbon\Carbon::createFromTimestamp($article['published_at'])
                                    ->locale(app()->getLocale())
                                    ->translatedFormat('d F Y, H:i') }}
                            </small>
                        @endif
                    </td>
                </tr>

                @if(!$loop->last)
                    <tr><td colspan="2"><hr noshade size="1"></td></tr>
                @endif
            @endforeach
        </table>

        <hr noshade size="1">

        <p>
            <a href="{{ route('features.news.index') }}">&laquo; {{ __('news.back_to_sources') }}</a>
            |
            <x-external-link url="{{ $source['url'] }}">{{ __('news.visit_original') }}</x-external-link>
        </p>
    @endif
@endsection
