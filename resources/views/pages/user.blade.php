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
            <button><a href="{{ route('ownedAuctions', ['id' => $user->id]) }}">Owned Auctions</a></button>
        </div>
@endsection
