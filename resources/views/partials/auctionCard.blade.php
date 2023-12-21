<a href="{{ route('auctions', ['id' => $auction->id]) }}">
    <article>
        <div class="image-container">
            <img src="{{ asset($auction->image) }}" alt="AuctionImage">
        </div>
        <div class="info-container">
            <h3>{{ $auction->name }}</h3>
            <p>Auctioneer: <a href="{{ route('user', ['id' => $auction->owner_id]) }}">{{ $auction->owner->name }}</a></p>
            <div class="image-container">
                <img src="{{ asset($auction->owner->img) }}" alt="{{ $auction->owner->name }}" width="100"
                    height="100" style="border-radius: 50%;">
            </div>
            <p>{{ $auction->description }}</p>

            <div class="status-container">
                @if ($auction->active)
                        <div class="status-bubble active">
                            <p>Active</p>
                        </div>

                        <p>Starting Date: {{ $auction->start_t }}</p>
                        <p>Closing Date: {{ $auction->end_t }}</p>
                @else
                    <div class="status-bubble closed">
                        <p>Closed</p>
                    </div>

                        <p>Starting Date: {{ ($auction->start_t) }}</p>
                        <p>Closing Date: {{ $auction->end_t }}</p>
                @endif
            </div>

        </div>
    </article>
</a>
