@extends('layouts.app')

@section('content')
<div class="auctions-list">
  @foreach ($auctions as $auction)
  <div class="auction-card">
    @include('partials.auctionCard', ['auction' => $auction])
  </div>
  @endforeach
</div>
{{-- <div class="pagination-icons"> --}}
  {{-- {{ $auctions->links() }}   --}}
{{-- </div> --}}

<a class="button" id="createAuctionButton" href="{{ route('createAuction') }}"> Create Auction </a>
@endsection
