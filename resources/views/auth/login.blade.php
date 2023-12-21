@extends('layouts.app')

@section('content')
<form method="POST" id="login-form">
    {{ csrf_field() }}

    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" >Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label>
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    </label>

    <button type="submit" formaction="{{ route('login') }}" id="login-form" class = 'button'>
        Login
    </button>
    <a class="button" href="{{ route('register') }}">Register</a>
    <a class="button" href="{{ route('forgotPassword') }}">Forgot your password?</a>
</form>
@endsection
