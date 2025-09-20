@extends('layout.app')

@section('title', __('ui.pages.search'))
@section('page_title', __('ui.pages.search'))

@section('content')
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <form class="form-inline" action="{{ route('features.search') }}" method="get">
                    <table border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td align="right"><label for="q"><strong>{{ app()->getLocale() === 'it' ? 'Query' : 'Query' }}</strong></label></td>
                            <td><input id="q" type="text" name="q" value="{{ $q }}" size="40"></td>
                            <td><input type="submit" value="{{ app()->getLocale() === 'it' ? 'Cerca' : 'Search' }}"></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>

    <hr noshade size="1">

    @if(isset($results) && $results)
        @if($results['heading'] || $results['abstract'])
            <table width="100%" border="0" cellspacing="0" cellpadding="4">
                <tr>
                    <td>
                        @if($results['heading'])
                            <strong>{{ $results['heading'] }}</strong><br>
                        @endif
                        @if($results['abstract'])
                            {{ $results['abstract'] }}
                            @if($results['abstract_url'])
                                <br><small><x-external-link url="{{ $results['abstract_url'] }}">{{ $results['abstract_url'] }}</x-external-link></small>
                            @endif
                        @endif
                    </td>
                </tr>
            </table>
            <hr noshade size="1">
        @endif

        @if(count($results['topics']))
            <p class="muted"><em>{{ app()->getLocale() === 'it' ? 'Argomenti correlati' : 'Related topics' }}</em></p>
            <table width="100%" border="0" cellspacing="0" cellpadding="4">
                @foreach($results['topics'] as $t)
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
            @if(!$results['heading'] && !$results['abstract'])
                <p>{{ app()->getLocale() === 'it'
                ? 'Nessuna risposta diretta trovata per questa query.'
                : 'No instant answers found for this query.' }}</p>
            @endif
        @endif
    @elseif(strlen($q))
        <p>{{ app()->getLocale() === 'it'
        ? 'Nessun risultato — integrazione backend in corso.'
        : 'No results yet — backend integration pending.' }}</p>
    @else
        <p class="muted">{{ app()->getLocale() === 'it'
        ? 'Scrivi una query e premi Cerca.'
        : 'Type a query and press Search.' }}</p>
    @endif
@endsection
