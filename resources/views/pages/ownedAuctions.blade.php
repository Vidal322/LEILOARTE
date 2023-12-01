@extends('layouts.app')

@section('content')
<div class="auctions-list">
    @foreach ($auctions as $auction)
        <div class="auction-card">
          @include('partials.auctionCard', ['auction' => $auction])
        </div>
    @endforeach
</div>
@endsection
