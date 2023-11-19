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
    {{-- if there is an entry in AuctionSave with auction_id and Auth::user()-> id --}}
    @if (\App\Http\Controllers\AuctionSaveController::exists(Auth::user()->id, $auction->id) == false)
    <form method="POST" action="{{ route('followAuctions', ['id' => $auction->id]) }}">
        {{ csrf_field() }}
    <button class="button button-outline" type = sumbit>Follow Auction</button>
    </form>
    @endif
    @if (\App\Http\Controllers\AuctionSaveController::exists(Auth::user()->id, $auction->id) == true)
    <form method="POST" action="{{ route('unfollowAuctions', ['id' => $auction->id]) }}">
        {{ csrf_field() }}
    <button class="button button-outline" type = sumbit>Unfollow Auction</button>
    </form>
    @endif
    @if ($auction->owner_id != Auth::user()->id)
    <button class="button button-outline"><a href="{{ route('createBidForm', ['id' => $auction->id]) }}">Place Bid</a></button>
    @endif 

    @if ($auction->owner_id != Auth::user()->id)
    <button class="button button-outline"><a href="{{ route('editAuctionForm', ['id' => $auction->id]) }}">Edit </a></button>
    <button class="button button-outline"><a href="{{ route('deleteAuction', ['id' => $auction->id]) }}">Delete </a></button>
    @endif
@endsection