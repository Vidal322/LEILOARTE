@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('editUser', ['id'=> $id]) }}">
    {{ csrf_field() }}

    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="username" >username</label>
    <input id="username" type="username" name="username" required>
    @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
    @endif

    <label for="name" >name</label>
    <input id="name" type="text" name="name" required>
    @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
    @endif


    <button type="submit">
        Save
    </button>
    <a class="button button-outline" href="{{ route('user', ['id'=> $id]) }}">Cancel</a>
</form>

@endsection