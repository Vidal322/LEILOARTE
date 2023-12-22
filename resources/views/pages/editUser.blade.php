@extends('layouts.app')

@section('title', 'Edit User')

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

    <label for="password" >password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label for="name" >name</label>
    <input id="name" type="text" name="name" required>
    @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
    @endif

    <label for="description" >description</label>
    <input id="description" type="text" name="description" required>
    @if ($errors->has('description'))
        <span class="error">
            {{ $errors->first('description') }}
        </span>
    @endif


    <button type="submit">
        Save
    </button class="button button-outline">
    <a class="button button-outline" href="{{ route('user', ['id'=> $id]) }}">Cancel</a>
</form>

<form method="POST" action=" {{ route('uploadFile') }} " enctype="multipart/form-data">
    @csrf
    <input name="file" type="file" required>
    <input name="id" type="number" value="{{ $id }}" hidden>
    <input name="type" type="text" value="users" hidden>
    <button type="submit">Submit</button class = "button button-outline">
</form>


@endsection