@extends('layout.app')

@section('title', __('image-search.title', [], null, app()->getLocale()) ?? 'Image Search')
@section('page_title', __('image-search.page_title', [], null, app()->getLocale()) ?? 'Image Search')

@section('content')
    @php
        $q         = (string) ($q ?? '');
        $drawings  = (bool)   ($drawings ?? false);
        $start     = max(1, (int) ($start ?? 1));
        $num       = max(1, min(10, (int) ($num ?? 10)));
        $results   = $results ?? null;
        $error     = $error ?? null;

        $baseQs = ['q'=>$q, 'num'=>$num];
        if ($drawings) { $baseQs['drawings'] = 1; }

        $prevUrl = null;
        $nextUrl = null;
        if ($results && is_array($results)) {
            $nextStart = $results['next_start'] ?? null;
            if ($start > 1) {
                $qs = $baseQs; $qs['start'] = max(1, $start - $num);
                $prevUrl = route('features.image-search', $qs);
            }
            if ($nextStart) {
                $qs = $baseQs; $qs['start'] = $nextStart;
                $nextUrl = route('features.image-search', $qs);
            }
        }

        $label_query   = __('image-search.form.query')  !== 'image-search.form.query'  ? __('image-search.form.query')  : 'Query';
        $label_submit  = __('image-search.form.submit') !== 'image-search.form.submit' ? __('image-search.form.submit') : 'Cerca';
        $label_draw    = __('image-search.form.drawings') !== 'image-search.form.drawings' ? __('image-search.form.drawings') : 'Solo disegni (lineart)';
        $label_safe    = __('image-search.form.safe')   !== 'image-search.form.safe'   ? __('image-search.form.safe')   : 'Safe Search';
        $label_on      = __('common.on')               !== 'common.on'                ? __('common.on')                : 'ON';
        $label_off     = __('common.off')              !== 'common.off'               ? __('common.off')               : 'OFF';
        $hint_start    = __('image-search.start_hint') !== 'image-search.start_hint'   ? __('image-search.start_hint')  : 'Inserisci una query per iniziare.';
        $hint_nores    = __('image-search.no_results_yet') !== 'image-search.no_results_yet' ? __('image-search.no_results_yet') : 'Nessun risultato (ancora).';
        $hint_noitems  = __('image-search.no_items')   !== 'image-search.no_items'     ? __('image-search.no_items')    : 'Nessuna immagine trovata.';
        $label_total   = __('image-search.total')      !== 'image-search.total'        ? __('image-search.total')       : 'Totale';
        $label_prev    = __('pagination.previous')     !== 'pagination.previous'       ? __('pagination.previous')      : 'Precedenti';
        $label_next    = __('pagination.next')         !== 'pagination.next'           ? __('pagination.next')          : 'Successivi';
    @endphp

    <div align="center">
        <!-- Form -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr><td align="center">
                    <form class="form-inline" action="{{ route('features.image-search') }}" method="get">
                        <table border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td align="right"><label for="q"><strong>{{ $label_query }}</strong></label></td>
                                <td><input id="q" type="text" name="q" value="{{ $q }}" size="40"></td>
                                <td><input type="submit" value="{{ $label_submit }}"></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">
                                    <label>
                                        <input type="checkbox" name="drawings" value="1" {{ $drawings ? 'checked' : '' }}>
                                        {{ $label_draw }}
                                    </label>

                                    <input type="hidden" name="start" value="1">
                                    <input type="hidden" name="num" value="{{ $num }}">
                                </td>
                            </tr>
                        </table>
                    </form>
                </td></tr>
        </table>

        <hr noshade size="1">

        @if(!empty($error))
            <p style="color:#b00;"><strong>{{ $error }}</strong></p>
            <hr noshade size="1">
        @endif

        @if(!isset($results) && strlen($q) === 0)
            <p class="muted">{{ $hint_start }}</p>
        @endif

        @if(isset($results))
            @php
                $items = (array)($results['items'] ?? []);
                $total = $results['total'] ?? null;
            @endphp

            @if($total !== null)
                <p class="muted">{{ $label_total }}: <strong>{{ number_format((int)$total, 0, ',', '.') }}</strong></p>
            @endif

            @if(count($items))
                <!-- Griglia 4 colonne -->
                <table width="100%" border="0" cellspacing="6" cellpadding="0">
                    @php $col = 0; @endphp
                    <tr>
                        @foreach($items as $it)
                            @php
                                $thumb = $it['thumbnail_url'] ?? $it['image_url'] ?? null;
                                $href  = $it['context_url'] ?? $it['image_url'] ?? '#';
                            @endphp
                            <td align="center" width="25%">
                                @if($thumb && $href)
                                    <div style="border:1px solid #ddd; padding:4px;">
                                        <a href="{{ $href }}" target="_blank" rel="noopener">
                                            <img src="{{ $thumb }}" alt="{{ e($it['title'] ?? 'image') }}" width="160">
                                        </a>
                                    </div>
                                @endif
                                <div style="margin-top:4px;">
                                    <small class="muted">
                                        {{ $it['mime'] ?? '' }}
                                        {{ ($it['width'] ?? null) && ($it['height'] ?? null) ? "· {$it['width']}×{$it['height']}" : '' }}
                                    </small>
                                </div>
                            </td>
                            @php $col++; if ($col % 4 === 0) echo '</tr><tr>'; @endphp
                        @endforeach
                        @while ($col % 4 !== 0) <td>&nbsp;</td> @php $col++; @endphp @endwhile
                    </tr>
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
