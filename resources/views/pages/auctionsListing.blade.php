@extends('layouts.app')

@section('content')
<div class="auctions_list">
  @foreach ($auctions as $auction)
    @include('partials.auctionCard', ['auction' => $auction])
  @endforeach
</div>
@endsection
