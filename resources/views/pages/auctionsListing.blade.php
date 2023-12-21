@extends('layouts.app')

@section('content')

<div class="auctions-list">
  @foreach ($auctions->data as $auction)
  <div class="auction-card">
    @include('partials.auctionCard', ['auction' => $auction])
  </div>
  @endforeach
</div>

@if(auth()->check() && auth()->user()->type != 'admin')
<a href="{{ route('createAuctionForm') }}">
    <button id="createAuctionButton">Create Auction</button>
</a>
@endif
@endsection
