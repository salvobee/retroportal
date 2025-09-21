@extends('layout.app')

@section('title', __('web-search.title'))
@section('page_title', __('web-search.page_title'))

@section('content')
    <div align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center">
                    <form class="form-inline" action="{{ route('features.search') }}" method="get">
                        <table border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td align="right">
                                    <label for="q"><strong>{{ __('web-search.form.query') }}</strong></label>
                                </td>
                                <td>
                                    <input id="q" type="text" name="q" value="{{ $q }}" size="40">
                                </td>
                                <td>
                                    <input type="submit" value="{{ __('web-search.form.submit') }}">
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>

        <hr noshade size="1">

        @php
            $heading  = data_get($results ?? [], 'heading');
            $abstract = data_get($results ?? [], 'abstract');
            $abstractUrl = data_get($results ?? [], 'abstract_url');
            $topics   = (array) data_get($results ?? [], 'topics', []);
        @endphp

        @if(!empty($results))
            @if($heading || $abstract)
                <table width="100%" border="0" cellspacing="0" cellpadding="4">
                    <tr>
                        <td>
                            @if($heading)
                                <strong>{{ $heading }}</strong><br>
                            @endif

                            @if($abstract)
                                {{ $abstract }}
                                @if($abstractUrl)
                                    <br>
                                    <small>
                                        <x-external-link url="{{ $abstractUrl }}">{{ $abstractUrl }}</x-external-link>
                                    </small>
                                @endif
                            @endif
                        </td>
                    </tr>
                </table>

                <hr noshade size="1">
            @endif

            @if(count($topics))
                <p class="muted"><em>{{ __('web-search.related_topics') }}</em></p>
                <table width="100%" border="0" cellspacing="0" cellpadding="4">
                    @foreach($topics as $t)
                        <tr>
                            <td width="5">•</td>
                            <td>
                                <x-external-link url="{{ $t['url'] }}">{{ $t['text'] }}</x-external-link><br>
                                <small class="muted">{{ $t['url'] }}</small>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                @if(!$heading && !$abstract)
                    <p>{{ __('web-search.no_instant') }}</p>
                @endif
            @endif
        @elseif(isset($q) && strlen((string)$q))
            <p>{{ __('web-search.no_results_yet') }}</p>
        @else
            <p class="muted">{{ __('web-search.start_hint') }}</p>
        @endif
    </div>
@endsection
