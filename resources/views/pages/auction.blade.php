@extends('layouts.app')

@section('content')
    <div class = "content">
        <h1> This is {{$auction->name}} Auction </h1>
        <div> description: {{$auction->description}} </div>
        <div> start date: {{$auction->start_t}} </div>
        <div> end date: {{$auction->end_t}} </div>
        <div> image: {{$auction->image}} </div>
        <div> owner_id: {{$auction->owner_id}} </div>
    </div>

    <form method="POST" action="{{ route('followAuctions', ['id' => $auction->id]) }}">
        {{ csrf_field() }}
    <button class="button button-outline" type = sumbit>Follow Auction</button>
    </form>
    <button class="button button-outline"><a href="{{ route('createBidForm', ['id' => $auction->id]) }}">Place Bid</a></button>
    <button class="button button-outline"><a href="{{ route('editAuctionForm', ['id' => $auction->id]) }}">Edit </a></button>
    <button class="button button-outline"><a href="{{ route('deleteAuction', ['id' => $auction->id]) }}">Delete </a></button>
@endsection