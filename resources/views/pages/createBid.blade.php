@extends('layouts.app')

@section('title', 'Create Bid')

@section('content')
<div class =createBidPage>
    <div class ="auctionInformation">
        <h3> {{ $auction->name }} </h3>
        <p>{{ $auction->description}}</p>
        <p> Starting Price: {{ $auction->starting_price}} </p>
        <h3> Bids </h3>
        <div class="bidList">
            @foreach ($auction->bids as $bid )
                <p> {{$bid->amount}}€ by <a href="{{ route('user', ['id'=> $bid->bidder->id])}}">{{$bid->bidder->name}}</p>
            @endforeach
            @if ($auction->bids == [])
                <p> no bids yet </p>
            @endif
        </div>
    </div>
    <div class="createBidForm">
        <form method="POST" action="{{ route('createBid', ['id'=> $auction->id]) }}">
            {{ csrf_field() }}

            <label for="amount">Amount</label>
            <input id="amount" type="number" step="0.01" name="amount" value="0" required autofocus>
            @if ($errors->has('amount'))
                <span class="error">
                {{ $errors->first('amount') }}
                </span>
            @endif

            <button type="submit">
                Place Bid
            </button>
            <a class="button button-outline" href="{{ route('auctions', ['id'=> $auction->id]) }}">Cancel</a>
        </form>
    </div>
</div>

@endsection
