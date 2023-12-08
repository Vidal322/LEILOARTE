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
    <button>Create Auction</button>
@endif
@endsection
