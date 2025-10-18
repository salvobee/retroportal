{{-- resources/views/auth/register.blade.php --}}
@extends('layout.guest')

@section('title', __('auth.register'))
@section('page_title', __('auth.register'))

@section('content')

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <table border="0" cellspacing="4" cellpadding="2" align="center">
            <tr>
                <td align="right"><label for="name"><strong>{{ __('auth.name') }}</strong></label></td>
                <td>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" size="30" required autofocus autocomplete="name">
                    @error('name')
                    <br><small style="color:#b00;">{{ $message }}</small>
                    @enderror
                </td>
            </tr>

            <tr>
                <td align="right"><label for="email"><strong>{{ __('auth.email') }}</strong></label></td>
                <td>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" size="30" required autocomplete="username">
                    @error('email')
                    <br><small style="color:#b00;">{{ $message }}</small>
                    @enderror
                </td>
            </tr>

            <tr>
                <td align="right"><label for="password"><strong>{{ __('auth.password') }}</strong></label></td>
                <td>
                    <input id="password" type="password" name="password" size="30" required autocomplete="new-password">
                    @error('password')
                    <br><small style="color:#b00;">{{ $message }}</small>
                    @enderror
                </td>
            </tr>

            <tr>
                <td align="right"><label for="password_confirmation"><strong>{{ __('auth.password_confirm') }}</strong></label></td>
                <td>
                    <input id="password_confirmation" type="password" name="password_confirmation" size="30" required autocomplete="new-password">
                    @error('password_confirmation')
                    <br><small style="color:#b00;">{{ $message }}</small>
                    @enderror
                </td>
            </tr>

            <tr>
                <td></td>
                <td align="right">
                    <a href="{{ route('login') }}">{{ __('auth.already_registered') }}</a>
                    &nbsp;
                    <input type="submit" value="{{ __('auth.register') }}">
                </td>
            </tr>
        </table>
    </form>

@endsection
