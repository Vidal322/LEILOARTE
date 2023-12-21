@extends ('layouts.app')

@section('content')
<form method="POST" action=" {{ route('sendEmail') }} " id="forgotPassword-form">
    {{ csrf_field() }}

    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <button type="submit">
        Send password reset link
    </button>



@endsection