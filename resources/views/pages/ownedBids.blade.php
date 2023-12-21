@extends('layouts.app')

@section('content')
<div class="bid-list">
    @foreach ($bids as $bid)
    <a href="{{ route('auctions', ['id' => $bid->auction->id]) }}">
        <div class="bid-card">
          @include('partials.bidCard', ['bid' => $bid])
        </div>
    @endforeach
</div>
@endsection
