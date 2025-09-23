@extends('layout.app')

@section('title', __('web-search.title'))
@section('page_title', __('web-search.page_title'))

@section('content')
    @php
        $q       = (string) ($q ?? '');
        $start   = max(1, (int) ($start ?? 1));
        $num     = max(1, min(10, (int) ($num ?? 10)));
        $results = $results ?? null;
        $error   = $error ?? null;

        $baseQs = ['q'=>$q, 'num'=>$num];

        $prevUrl = null;
        $nextUrl = null;
        if ($results && is_array($results)) {
            $nextStart = $results['next_start'] ?? null;
            if ($start > 1) {
                $qs = $baseQs; $qs['start'] = max(1, $start - $num);
                $prevUrl = route('features.search', $qs);
            }
            if ($nextStart) {
                $qs = $baseQs; $qs['start'] = $nextStart;
                $nextUrl = route('features.search', $qs);
            }
        }

        $label_query  = __('web-search.form.query')  !== 'web-search.form.query'  ? __('web-search.form.query')  : 'Query';
        $label_submit = __('web-search.form.submit') !== 'web-search.form.submit' ? __('web-search.form.submit') : 'Cerca';
        $hint_start   = __('web-search.start_hint')  !== 'web-search.start_hint'  ? __('web-search.start_hint')  : 'Inserisci una query per iniziare.';
        $hint_nores   = __('web-search.no_results_yet') !== 'web-search.no_results_yet' ? __('web-search.no_results_yet') : 'Nessun risultato (ancora).';
        $hint_noitems = __('web-search.no_items')    !== 'web-search.no_items'    ? __('web-search.no_items')    : 'Nessun risultato trovato.';
        $label_total  = __('web-search.total')       !== 'web-search.total'       ? __('web-search.total')       : 'Totale';
        $label_prev   = __('pagination.previous')    !== 'pagination.previous'    ? __('pagination.previous')    : 'Precedenti';
        $label_next   = __('pagination.next')        !== 'pagination.next'        ? __('pagination.next')        : 'Successivi';
    @endphp

    <div align="center">
        <!-- Form ricerca web -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr><td align="center">
                    <form class="form-inline" action="{{ route('features.search') }}" method="get">
                        <table border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td align="right"><label for="q"><strong>{{ $label_query }}</strong></label></td>
                                <td><input id="q" type="text" name="q" value="{{ $q }}" size="40"></td>
                                <td><input type="submit" value="{{ $label_submit }}"></td>
                            </tr>
                        </table>
                        <input type="hidden" name="start" value="1">
                        <input type="hidden" name="num" value="{{ $num }}">
                    </form>
                </td></tr>
        </table>

        <hr noshade size="1">

        {{-- Errori --}}
        @if(!empty($error))
            <p style="color:#b00;"><strong>{{ $error }}</strong></p>
            <hr noshade size="1">
        @endif

        {{-- Stato iniziale --}}
        @if(!isset($results) && strlen($q) === 0)
            <p class="muted">{{ $hint_start }}</p>
        @endif

        {{-- Risultati --}}
        @if(isset($results))
            @php
                $items = (array)($results['items'] ?? []);
                $total = $results['total'] ?? null;
            @endphp

            @if($total !== null)
                <p class="muted">{{ $label_total }}: <strong>{{ number_format((int)$total, 0, ',', '.') }}</strong></p>
            @endif

            @if(count($items))
                <table width="100%" border="0" cellspacing="0" cellpadding="4">
                    @foreach($items as $it)
                        <tr valign="top">
                            <td width="5">•</td>
                            <td>
                                @if(!empty($it['url']))
                                    <div>
                                        <x-external-link url="{{ $it['url'] }}"><strong>{{ $it['title'] ?: $it['url'] }}</strong></x-external-link>
                                    </div>
                                @else
                                    <div><strong>{{ $it['title'] ?? '' }}</strong></div>
                                @endif
                                @if(!empty($it['snippet']))
                                    <div>{{ $it['snippet'] }}</div>
                                @endif
                                <small class="muted">
                                    {{ $it['display_url'] ?? $it['source'] ?? '' }}
                                </small>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p>{{ $hint_noitems }}</p>
            @endif

            {{-- Paginazione --}}
            @if($prevUrl || $nextUrl)
                <hr noshade size="1">
                <table border="0" cellspacing="0" cellpadding="4">
                    <tr>
                        <td>
                            @if($prevUrl)
                                <a href="{{ $prevUrl }}">&laquo; {{ $label_prev }}</a>
                            @else
                                <span class="muted">&laquo; {{ $label_prev }}</span>
                            @endif
                        </td>
                        <td width="10">&nbsp;</td>
                        <td>
                            @if($nextUrl)
                                <a href="{{ $nextUrl }}">{{ $label_next }} &raquo;</a>
                            @else
                                <span class="muted">{{ $label_next }} &raquo;</span>
                            @endif
                        </td>
                    </tr>
                </table>
            @endif
        @elseif(isset($q) && strlen($q))
            <p>{{ $hint_nores }}</p>
        @endif
    </div>
@endsection
