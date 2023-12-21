@extends('layouts.app')

@section('content')
    <div class="user-profile">
        <img class=profile-img src="{{ asset($user->img) }}" alt="UserImage">
        <div class="info">
            <div>{{ $user->name }}</div>
            <div>Username: {{ $user->username }}</div>
            <div>Email: {{ $user->email }}</div>
            <div>Rate: {{ round($user->rate, 2)*100 }} % </div>
            <div>Description: {{ $user->description }}</div>
        </div>
    </div>
    <div class="button-container">
        <button class="button button-outline"><a href="{{ route('ownedAuctions', ['id' => $user->id]) }}">Owned
                Auctions</a></button>
        <button class="button button-outline"><a href="{{ route('userBids', ['id' => $user->id]) }}">Owned
                Bids</a></button>
    </div>

    @if (Auth::check())
        @if (Auth::user()->id == $user->id)
            <div class="button-container">
                <form method="POST" action="{{ route('deleteUser', ['id' => $user->id]) }}">
                    {{ csrf_field() }}
                    <button class="button button-outline">Delete</button>
                </form>
            </div>
        @elseif (Auth::user()->type == 'admin')
            <div class="button-container">
                <form method="POST" action="{{ route('deleteUser', ['id' => $user->id]) }}">
                    {{ csrf_field() }}
                    <button class="button button-outline">Delete</button>
                </form>
            </div>
        @else
            <div class="button-container">
                <button class="button button-outline">Follow</button>
                <form method="POST" action="{{ route('rateUser', ['id' => $user->id]) }}">
                    {{ csrf_field() }}
                    <label for="rating">Rate this user:</label>
                    <button id = "rating-button" type="submit" name="rate" value=1 class="button button-outline">Like 👍</button>
                    <button id = "rating-button" type="submit" name="rate" value=0 class="button button-outline">Dislike 👎</button>
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
        <form method="POST" action="{{ route('blockUser', ['id' => $user->id]) }}">
                {{ csrf_field() }}
                <button class="button button-outline"> <a> Block </a> </button>
            </form>
        @endif

        @if (Auth::check() && Auth::user()->type == 'admin' && Auth::user()->id == $user->id)
            <button class="button button-outline"><a href="{{ route('blockedUsers') }}">Blocked Users</a></button>
        @endif

        <!-- {{-- if not owner --}}
        @if (Auth::check() && Auth::user()->id != $user->id)
        <button class="button button-outline"><a href="{{ route('ownedAuctions', ['id' => $user->id]) }}">Owned Auctions</a></button>
        @endif -->

    @endif
@endsection
