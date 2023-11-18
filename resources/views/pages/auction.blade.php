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
    <button class="button button-outline"><a href="{{ route('createBidForm', ['id' => $auction->id]) }}">Place Bid</a></button>
    <button class="button button-outline"><a href="{{ route('editAuctionForm', ['id' => $auction->id]) }}">Edit Button</a></button>
@endsection