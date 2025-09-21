{{-- News Sources: Category-based source selection --}}
@extends('layout.app')

@section('title', __('news.title'))
@section('page_title', __('news.title'))

@section('content')
    @if(empty($sourcesByCategory))
        <p class="muted">{{ __('news.no_sources') }}</p>
    @else
        <p class="muted">{{ __('news.select_source') }}</p>

        @foreach($sourcesByCategory as $categoryName => $sources)
            <h3>{{ $categoryName }}</h3>

            <table width="100%" border="0" cellspacing="0" cellpadding="4">
                @foreach($sources as $source)
                    <tr valign="top">
                        <td width="5">•</td>
                        <td>
                            <strong>
                                <a href="{{ route('features.news.source', $source['id']) }}">{{ $source['name'] }}</a>
                            </strong>

                            @if($source['description'])
                                <br><small class="muted">{{ $source['description'] }}</small>
                            @endif

                            @if($source['country'])
                                <br><small class="muted">{{ __('news.country') }}: {{ $source['country'] }}</small>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>

            <hr noshade size="1">
        @endforeach

        <p class="muted">
            <small>
                {{ __('news.sources_info') }}
            </small>
        </p>
    @endif
@endsection
