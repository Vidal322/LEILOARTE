@extends('layouts.app')

@section('content')
<div class="auctions_list">
  @foreach ($auctions as $auction)
    @include('partials.auctionCard', ['auction' => $auction])
  @endforeach
</div>
<div class="pagination-icons">
  {{ $auctions->links() }}  
</div>

<a class="button" id="createAuctionButton" href="{{ route('createAuction') }}"> Create Auction </a>
@endsection
  