<a href="{{ route('auctions', ['id' => $auction->id]) }}">
    <article class="auction-card">
        <div class="image-container">
            <img src="{{ asset($auction->image) }}" alt="AuctionImage">
        </div>
        <div class="info-container">
            <h3>{{ $auction->name }}</h3>
            <a href="{{ route('user', ['id' => $auction->owner_id]) }}">
                <div class="user-section">
                    <div class="image-container">
                        <img src="{{ asset($auction->owner->img) }}" alt="{{ $auction->owner->name }}" width="100"
                            height="100" style="border-radius: 50%;">
                    </div>
                <p>{{ $auction->owner->name }}</p>

                </div>
            </a>
            <h3>Auction Overview</h3>
            <div class="auction-overview">
                <div class="auction-values">
                    <div class="auction-dates">
                        <p>Started: {{ substr($auction->start_t, 0, -3) }}</p>
                        <p>Closing: {{ substr($auction->start_t, 0, -3) }}</p>
                    </div>
                    <div class="auction-prices">
                        <p>Starting Price: {{ $auction->starting_price }}€</p>
                        <p>Top Bid: {{last($auction->bids)->amount}}€</p>
                    </div>
                </div>
                <h3> Description </h3>
                <p>{{ $auction->description }}</p>
            </div>

                @if ($auction->active)
                    <div class="status-bubble active">
                        <p>Active</p>
                    </div>
                @else
                    <div class="status-bubble closed">
                        <p>Closed</p>
                    </div>
                @endif
        </div>
    </article>
</a>
