@extends ('layouts.app')

@section('content')

<form method="POST" action=" {{ route('updatePassword') }} " id="forgotPassword-form">
    {{ csrf_field() }}

    <input name="token" type="hidden" value="{{ $token }}">

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required autofocus>
    @if ($errors->has('password'))
        <span class="error">
          {{ $errors->first('password') }}
        </span>
    @endif
    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required autofocus>
    @if ($errors->has('password_confirmation'))
        <span class="error">
          {{ $errors->first('password_confirmation') }}
        </span>
    @endif

    <button type="submit">
        Reset password
    </button>

</form>

@endsection
