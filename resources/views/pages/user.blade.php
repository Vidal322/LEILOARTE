@extends('layouts.app')

@section('content')
        <div class="content">
            <h1>This is {{$user->name}} page</h1>
            <div>email: {{$user->email}}</div>
            <div>username: {{$user->username}}</div>
            <div>description: {{$user->description}}</div>
            <div>image: {{$user->img}}</div>
            <div>rate: {{$user->rate}}</div>
            <div>type: {{$user->type}}</div>
            <div>deleted: {{$user->deleted}}</div>
        </div>
        <button class="button button-outline"><a href="{{ route('ownedAuctions', ['id' => $user->id]) }}">Owned Auctions</a></button>
        <button class="button button-outline"><a href="{{ route('editUserForm', ['id' => $user->id]) }}">Edit</a></button>
        <button class="button button-outline"><a href="{{ route('deleteUser', ['id' => $user->id]) }}">Delete</a></button>
@endsection
