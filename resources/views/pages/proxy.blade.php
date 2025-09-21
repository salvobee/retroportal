@extends('layout.app')

@section('title', $page_title)
@section('page_title', $page_title)

@section('content')
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr bgcolor="{{ $theme_palette['bg'] }}">
            <td>
                <small class="muted">
                    <strong>{{ __('ui.site_name') }}</strong> — Reader Proxy
                    &nbsp;|&nbsp;
                    <a href="{{ $origin_url }}" target="_blank">Open original</a>
                    &nbsp;|&nbsp;
                    <a href="{{ url('/') }}">Home</a>
                </small>
            </td>
        </tr>
    </table>

    <hr noshade size="1">

    {{-- Error block --}}
    @if(!empty($error))
        <p style="color:#b00; white-space: pre-line;"><strong>{{ $error }}</strong></p>
        <hr noshade size="1">
    @endif

    {{-- Proxied and simplified content --}}
    @if(!empty($body_html))
        <div>{!! $body_html !!}</div>
    @endif
@endsection
