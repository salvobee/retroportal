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
        /* <![CDATA[ */
        body { margin: 8px; font-family: Arial, Helvetica, sans-serif; }
        .site-name { font-weight: bold; }
        .muted { font-size: 90%; color: {{ $theme_palette['muted'] }}; }
        hr { border: 0; height: 1px; background: {{ $theme_palette['border'] }}; }
        .nav { margin: 6px 0; }
        .nav a { text-decoration: none; }
        .theme, .lang, .auth { font-size: 90%; margin-top: 4px; }
        .wrap { margin: 0; padding: 0 6px; }

        @media screen and (min-width: 640px) {
            .wrap { max-width: 72ch; margin: 0 auto; padding: 0 12px; }
        }
        @media screen and (min-width: 960px) {
            .wrap { max-width: 960px; }
        }
        /* ]]> */
    </style>
</head>

<body bgcolor="{{ $theme_palette['bg'] }}"
      text="{{ $theme_palette['text'] }}"
      link="{{ $theme_palette['link'] }}"
      vlink="{{ $theme_palette['vlink'] }}"
      alink="{{ $theme_palette['alink'] }}">

<basefont face="Arial, Helvetica, sans-serif" size="3">

<div class="wrap">

    <!-- HEADER -->
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
                <div class="theme">
                    @if($theme_mode === 'dark')
                        <a href="{{ route('settings.theme', ['mode' => 'light']) }}">{{ __('ui.theme_light') }}</a>
                    @else
                        <a href="{{ route('settings.theme', ['mode' => 'dark']) }}">{{ __('ui.theme_dark') }}</a>
                    @endif
                </div>
                <div class="lang">
                    <strong>{{ __('ui.lang.label') }}:</strong>
                    <small>[ {{ __('ui.lang.current') }}: {{ strtoupper(app()->getLocale()) }} ] |
                        <a href="{{ route('settings.lang', ['locale' => 'en']) }}">EN</a> |
                        <a href="{{ route('settings.lang', ['locale' => 'it']) }}">IT</a>
                    </small>
                </div>
                <div class="auth">
                    @guest
                        <a href="{{ route('login') }}">{{ __('auth.login') }}</a> /
                        <a href="{{ route('register') }}">{{ __('auth.register') }}</a>
                    @else
                        <a href="{{ route('dashboard.profile') }}">{{ Auth::user()->name }}</a>
                        /
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none; border:0; padding:0; margin:0; cursor:pointer; font:inherit; color:inherit; text-decoration:underline;">
                                {{ __('auth.logout') }}
                            </button>
                        </form>
                    @endguest
                </div>
            </td>
        </tr>
    </table>

    <!-- NAV -->
    <hr noshade size="1">
    <div class="nav" id="navigation">
        <strong>Menu:</strong>
        <a href="{{ route('features.search') }}">{{ __('web-search.title') }}</a> |
        <a href="{{ route('features.news.index') }}">{{ __('news.title') }}</a> |
        <a href="{{ route('features.weather.form') }}">{{ __('weather.title') }}</a> |
        <a href="{{ route('features.wikipedia') }}">{{ __('encyclopedia.title') }}</a> |
        <a href="{{ route('chatbot.index') }}">{{ __('ai.title') }}</a>
    </div>
    <hr noshade size="1">

    <!-- CONTENT -->
    <a name="content"></a>
    <h1 align="center">
        @hasSection('page_title')
            @yield('page_title')
        @else
            {{ $page_title ?? __('ui.pages.home') }}
        @endif
    </h1>

    @hasSection('breadcrumbs')
        <div class="muted">@yield('breadcrumbs')</div>
        <hr noshade size="1">
    @endif

    @yield('content')

    <!-- FOOTER -->
    <hr noshade size="1">
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
            <td align="left">
                <small>&copy; {{ date('Y') }} {{ config('app.name') }}.</small>
            </td>
            <td align="right">
                <small></small>
            </td>
        </tr>
    </table>

</div>
</body>
</html>
