@extends('layouts.app')

@section('content')
        <div class="user-profile">
            <img class= profile-img src="{{ asset($user->img) }}" alt="UserImage">
            <div class="info">
                <div>{{$user->name}}</div>
                <div>Username: {{$user->username}}</div>
                <div>Email: {{$user->email}}</div>
                <div>Rate: {{$user->rate}}</div>
                <div>Description: {{$user->description}}</div>
            </div>
        </div>
        <div class="button-container">
            <button class="button button-outline"><a href="{{ route('ownedAuctions', ['id' => $user->id]) }}">Owned Auctions</a></button>
            <button class="button button-outline"><a href="{{ route('userBids', ['id' => $user->id]) }}">Owned Bids</a></button>
        </div>

        {{-- if owner--}}
        @if (Auth::check() && Auth::user()->id == $user->id)
        <div class="button-container">
            <button class="button button-outline"><a href="{{ route('followedAuctions', ['id' => $user->id]) }}">Followed Auctions</a></button>
            <button class="button button-outline"><a href="{{ route('editUserForm', ['id' => $user->id]) }}">Edit</a></button>
            <form method="POST" action="{{ route('deleteUser', ['id' => $user->id]) }}">
                {{ csrf_field() }}
                <button class="button button-outline"> <a> Delete </a> </button>
            </form>
        </div>
        @endif

        {{-- if admin--}}
        @if (Auth::check() && Auth::user()->type == 'admin' && Auth::user()->id != $user->id)
        <div class="button-container">
            <form method="POST" action="{{ route('deleteUser', ['id' => $user->id]) }}">
                {{ csrf_field() }}
                <button class="button button-outline">Delete</button>
            </form>
        </div>
        @endif

        <!-- {{-- if not owner --}}
        @if (Auth::check() && Auth::user()->id != $user->id)
        <button class="button button-outline"><a href="{{ route('ownedAuctions', ['id' => $user->id]) }}">Owned Auctions</a></button>
        @endif -->

    @endsection
