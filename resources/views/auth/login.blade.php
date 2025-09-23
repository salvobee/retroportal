@extends('layout.guest')

@section('title', __('auth.login'))
@section('page_title', __('auth.login'))

@section('content')

    {{-- Messaggi di stato (es. reset password ok) --}}
    @if (session('status'))
        <p style="color:green;">
            {{ session('status') }}
        </p>
        <hr noshade size="1">
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <table border="0" cellspacing="4" cellpadding="2" align="center">
            <tr>
                <td align="right"><label for="email"><strong>{{ __('auth.email') }}</strong></label></td>
                <td>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" size="30" required autofocus autocomplete="username">
                    @error('email')
                    <br><small style="color:#b00;">{{ $message }}</small>
                    @enderror
                </td>
            </tr>

            <tr>
                <td align="right"><label for="password"><strong>{{ __('auth.password') }}</strong></label></td>
                <td>
                    <input id="password" type="password" name="password" size="30" required autocomplete="current-password">
                    @error('password')
                    <br><small style="color:#b00;">{{ $message }}</small>
                    @enderror
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <label>
                        <input type="checkbox" name="remember" id="remember_me" value="1">
                        {{ __('auth.remember') }}
                    </label>
                </td>
            </tr>

            <tr>
                <td></td>
                <td align="right">

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">{{ __('auth.register') }}</a> |
                    @endif
{{--                    @if (Route::has('password.request'))--}}
{{--                        <a href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a> |--}}
{{--                    @endif--}}
                    &nbsp;
                    <input type="submit" value="{{ __('auth.login') }}">
                </td>
            </tr>
        </table>
    </form>

@endsection
