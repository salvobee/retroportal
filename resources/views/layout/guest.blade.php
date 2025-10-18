<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html lang="{{ app()->getLocale() ?? 'en' }}">
<head>
    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name') }}
        @else
            {{ $title ?? config('app.name', 'Site') }}
        @endif
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        body { margin: 8px; font-family: Arial, Helvetica, sans-serif; }
        .wrap { margin: 0; padding: 0 6px; }
        .muted { font-size: 90%; color: {{ $theme_palette['muted'] ?? '#666' }}; }
        hr { border: 0; height: 1px; background: {{ $theme_palette['border'] ?? '#ccc' }}; }
        .auth-box { border: 1px solid {{ $theme_palette['border'] ?? '#ccc' }};
            padding: 12px;
            background: {{ $theme_palette['bg'] ?? '#fff' }};
            max-width: 400px;
            margin: 24px auto; }
        @media screen and (min-width: 640px) {
            .wrap { max-width: 72ch; margin: 0 auto; padding: 0 12px; }
        }
    </style>
</head>

<body bgcolor="{{ $theme_palette['bg'] ?? '#ffffff' }}"
      text="{{ $theme_palette['text'] ?? '#000000' }}"
      link="{{ $theme_palette['link'] ?? '#0000ee' }}"
      vlink="{{ $theme_palette['vlink'] ?? '#551a8b' }}"
      alink="{{ $theme_palette['alink'] ?? '#ff0000' }}">

<div class="wrap">

    <!-- HEADER -->
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
            <td align="center">
                <div class="site-name">
                    <a href="{{ url('/') }}">{{ __('ui.site_name') }}</a>
                </div>
                <div class="muted">
                    {{ $tagline ?? __('ui.tagline') }}
                </div>
            </td>
        </tr>
    </table>

    <hr noshade size="1">

    <!-- AUTH CONTENT -->
    <div class="auth-box">
        @yield('content')
    </div>

    <!-- FOOTER -->
    <hr noshade size="1">
    <div align="center">
        <small>&copy; {{ date('Y') }} {{ config('app.name') }}.</small>
    </div>
</div>

</body>
</html>
