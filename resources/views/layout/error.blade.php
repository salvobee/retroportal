<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html lang="en">
<head>
    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name') }}
        @else
            {{ config('app.name', 'Site') }} - Error
        @endif
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        body { margin: 8px; font-family: Arial, Helvetica, sans-serif; }
        .wrap { max-width: 72ch; margin: 0 auto; padding: 0 8px; }
        h1 { text-align: center; }
        p { text-align: center; }
        a { text-decoration: none; color: #00f; }
        hr { border: 0; height: 1px; background: #999; }
    </style>
</head>
<body>
<div class="wrap">

    <h1>
        @yield('page_title', 'Error')
    </h1>

    <hr noshade size="1">

    @yield('content')

    <hr noshade size="1">
    <p><small>&copy; {{ date('Y') }} {{ config('app.name') }}</small></p>

</div>
</body>
</html>
