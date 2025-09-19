<!-- resources/views/layout/app.blade.php -->
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

    <!--
      Minimal, legacy-friendly CSS.
      Old browsers that ignore CSS will fall back to <basefont> and <body> color attributes.
      Use system sans-serif (Arial/Helvetica) for maximum cross-platform availability.
    -->
    <style type="text/css">
        /* <![CDATA[ */
        body { margin: 8px; font-family: Arial, Helvetica, sans-serif; }
        .wrap { max-width: 980px; margin: 0 auto; }
        .site-name { font-weight: bold; }
        .nav ul { list-style: square; margin: 0; padding-left: 16px; }
        .muted { font-size: 90%; color: {{ $theme_palette['muted'] }}; }
        hr { border: 0; height: 1px; background: {{ $theme_palette['border'] }}; }
        .lang a { text-decoration: none; }
        /* ]]> */
    </style>
</head>

<!--
  Legacy color attributes ensure proper theming on very old browsers (IE 1.0, Netscape 2/3).
  Values are provided by the palette set in session and shared via view composer.
-->
<body bgcolor="{{ $theme_palette['bg'] }}"
      text="{{ $theme_palette['text'] }}"
      link="{{ $theme_palette['link'] }}"
      vlink="{{ $theme_palette['vlink'] }}"
      alink="{{ $theme_palette['alink'] }}">

<!-- Base font for pre-CSS browsers; modern browsers will use CSS above -->
<basefont face="Arial, Helvetica, sans-serif" size="3">

<!-- Skip links improve accessibility for text/keyboard-based browsing -->
<a href="#content" accesskey="s">Skip to content</a> | <a href="#navigation">Skip to navigation</a>

<div class="wrap">

    <!-- Header -->
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
            <td>
                <div class="site-name">
                    <a href="{{ url('/') }}">{{ __('ui.site_name') }}</a>
                    <small>— {{ ucfirst($theme_mode) }} theme</small>
                </div>
                <div class="muted">
                    @yield('tagline', $tagline ?? '')
                </div>
            </td>
            <td align="right" valign="top">
                <!-- Theme switch without JavaScript -->
                @if($theme_mode === 'dark')
                    <a href="{{ route('theme.set', ['mode' => 'light']) }}">{{ __('ui.theme_light') }}</a>
                @else
                    <a href="{{ route('theme.set', ['mode' => 'dark']) }}">{{ __('ui.theme_dark') }}</a>
                @endif
                <br>

                <!-- Language selector: simple links for legacy compatibility -->
                <div class="lang">
                    <small><strong>{{ __('ui.lang.label') }}:</strong>
                        [ {{ __('ui.lang.current') }}: {{ strtoupper(app()->getLocale()) }} ]
                        |
                        <a href="{{ route('lang.set', ['locale' => 'en']) }}">{{ __('ui.lang.en') }}</a>
                        |
                        <a href="{{ route('lang.set', ['locale' => 'it']) }}">{{ __('ui.lang.it') }}</a>
                    </small>
                </div>
            </td>
        </tr>
    </table>

    <!-- Two-column layout via tables (reliable on pre-CSS browsers) -->
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr valign="top">
            <!-- NAVIGATION -->
            <td width="200" id="navigation">
                <div class="nav">
                    <strong>Menu</strong>
                    @section('nav')
{{--                        <ul>--}}
{{--                            <li><a href="{{ route('search') }}">{{ __('ui.menu.search') }}</a></li>--}}
{{--                            <li><a href={{ route('news') }}>{{ __('ui.menu.news') }}</a></li>--}}
{{--                            <li><a href="{{ route('weather') }}">{{ __('ui.menu.weather') }}</a></li>--}}
{{--                            <li><a href="{{ route('wikipedia') }}">{{ __('ui.menu.wikipedia') }}</a></li>--}}
{{--                        </ul>--}}
                    @show
                </div>

                @hasSection('nav_extra')
                    <hr noshade size="1">
                    <div class="nav">
                        @yield('nav_extra')
                    </div>
                @endif
            </td>

            <!-- MAIN CONTENT -->
            <td id="content">
                <h1>
                    @hasSection('page_title')
                        @yield('page_title')
                    @else
                        {{ $page_title ?? __('ui.pages.home') }}
                    @endif
                </h1>

                <!-- Optional text breadcrumbs (great for text-mode browsers) -->
                @hasSection('breadcrumbs')
                    <div class="muted">@yield('breadcrumbs')</div>
                    <hr noshade size="1">
                @endif

                @yield('content')
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <hr noshade size="1">
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
            <td align="left">
                <small>&copy; {{ date('Y') }} {{ config('app.name') }}.</small>
            </td>
            <td align="right">
                <small>
{{--                    <a href="{{ route('sitemap') }}">{{ __('ui.menu.sitemap') }}</a> |--}}
{{--                    <a href="{{ url('/text-only') }}">{{ __('ui.menu.textonly') }}</a>--}}
                </small>
            </td>
        </tr>
    </table>

</div>
</body>
</html>
