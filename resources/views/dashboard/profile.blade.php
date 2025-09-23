@extends('layout.app')

@section('title', __('ui.pages.profile'))
@section('page_title', __('ui.pages.profile'))

@section('content')

    @if(session('status'))
        <p style="color:green;">{{ session('status') }}</p>
        <hr noshade size="1">
    @endif

    <h2>{{ __('Profile information') }}</h2>

    <form method="POST" action="{{ route('dashboard.profile.update') }}">
        @csrf
        <table border="0" cellspacing="4" cellpadding="2">
            <tr>
                <td align="right"><label for="name"><strong>{{ __('auth.name') }}</strong></label></td>
                <td>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" size="40" required>
                    @error('name')<br><small style="color:#b00;">{{ $message }}</small>@enderror
                </td>
            </tr>
            <tr>
                <td align="right"><label for="email"><strong>{{ __('auth.email') }}</strong></label></td>
                <td>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" size="40" required>
                    @error('email')<br><small style="color:#b00;">{{ $message }}</small>@enderror
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="right"><input type="submit" value="{{ __('Save profile') }}"></td>
            </tr>
        </table>
    </form>

    <hr noshade size="1">

    <h2>{{ __('API Keys') }}</h2>

    <form method="POST" action="{{ route('dashboard.api.update') }}">
        @csrf
        <table border="0" cellspacing="4" cellpadding="2">
            <tr>
                <td align="right"><label for="openai"><strong>OpenAI</strong></label></td>
                <td>
                    <input type="text" id="openai" name="openai" value="{{ old('openai', optional($user->apiKeys->where('type','openai')->first())->key) }}" size="50">
                </td>
            </tr>
            <tr>
                <td align="right"><label for="openweathermap"><strong>OpenWeatherMap</strong></label></td>
                <td>
                    <input type="text" id="openweathermap" name="openweathermap" value="{{ old('openweathermap', optional($user->apiKeys->where('type','openweathermap')->first())->key) }}" size="50">
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="right"><input type="submit" value="{{ __('Save API keys') }}"></td>
            </tr>
        </table>
    </form>

@endsection
