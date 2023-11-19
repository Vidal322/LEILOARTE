@extends('layouts.app')

@section('content')
<div class="auctions_list">
  @foreach ($auctions as $auction)
    <div class="auction-card">
      <div class="image-container">
        <img src="{{ $auction->image }}" alt="AuctionImage">
      </div>
      <div class="info-container">
        <h2>{{ $auction->name }}</h2>
        <p>By: {{ $auction->owner_id }}</p>
        <p>{{ $auction->description }}</p>
      </div>
    </div>
  @endforeach
</div>
@endsection
  