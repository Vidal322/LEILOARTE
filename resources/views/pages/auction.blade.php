@extends('layouts.app')

@section('title', $auction->name . ' - Auction Details')

@section('content')
    <div class="display-auction">
        <div class="left-column">
            <h2><div class="underline-text"> {{$auction->name}} </div></h2>
            <img src="{{ asset($auction->image) }}" alt="Auction Image">
            <div>Auctioneer: <a href="{{route('user', ['id' => $auction->owner_id])}}">{{ $auction->owner->name }}</a></div>
        </div>
        <div class="right-column">
        <div class="auction-description">
            <h2><div class="underline-text">Item Overview</div></h2>
            <div>{{ $auction->description }}</div>
            <h2><div class="underline-text">Auction Details</div></h2>
            <div>This auction started on {{ $auction->start_t }}</div>

            @if ($auction->active)
                <div>This auction will close on {{ $auction->end_t }}</div>
            @else
                <div>This auction closed on {{ $auction->end_t }}</div>
            @endif
        </div>

            <div class="auction-bids">
                <h2 class="underline-text">Bids</h2>
                <div> Starting Price: {{ $auction->starting_price }}€</div>
                <div>Highest Bid:
                @if (!count($auction->bids))
                        No bids yet
                @else
                    <?php
                    $highestBid = $auction->bids()->with('bidder')->get()->sortByDesc('amount')->first();
                    $bidderName = $highestBid->bidder->name ?? 'null';
                    ?>
                    {{ $highestBid->amount }}€ by
                    <a href="{{ route('user', ['id' => $highestBid->user_id  ]) }}">{{ $bidderName}} </a>
                @endif
                </div>
                <div>
                    Bids: {{ count($auction->bids) }}
                </div>

                {{-- if user is not owner --}}
                @if(Auth::check() && $auction->owner_id != Auth::user()->id && $auction->active && last($auction->bids)??[]->user_id != Auth::user()->id)
                    <button class="button button-outline"><a href="{{ route('createBidForm', ['id' => $auction->id]) }}">Place Bid</a></button>
                @endif

            </div>
        </div>
        @if(Auth::check() && $auction->owner_id != Auth::user()->id)
            {{-- if user is not following --}}
            @if ($auction->auctionsSaved->where('user_id', Auth::user()->id)->isEmpty())
                <form method="POST" action="{{ route('followAuctions', ['id' => $auction->id]) }}">
                    {{ csrf_field() }}
                <button class="button button-outline" type = sumbit>Follow Auction</button>
                </form>
            @endif

            {{-- if user is following --}}
            @if (Auth::check() && $auction->owner_id != Auth::user()->id  && !($auction->auctionsSaved->where('user_id', Auth::user()->id)->isEmpty()))
                <form method="POST" action="{{ route('unfollowAuctions', ['id' => $auction->id]) }}">
                    {{ csrf_field() }}
                <button class="button button-outline" type = sumbit>Unfollow Auction</button>
                </form>
            @endif
        @endif

        {{-- if user is owner --}}
        @if (Auth::check() &&$auction->owner_id == Auth::user()->id)
            <div class="edit-delete-buttons">
                <button class="button button-outline"><a href="{{ route('editAuctionForm', ['id' => $auction->id]) }}">Edit </a></button>
                <button class="button button-outline"><a href="{{ route('deleteAuction', ['id' => $auction->id]) }}">Delete </a></button>
            </div>
        @endif

    </div>
@endsection
