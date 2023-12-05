<a href="{{ route('userBids', ['id' => $bid->user_id]) }}">
    <article class="{{ $bid->top_bid ? 'top-bid' : 'normal-bid' }}">
        <div class="image-container">
            <img src="{{ route('auctions', ['id' => $bid->auction]) }}" alt="AuctionImage">
            {{ $bid->auction->image }}
        </div>
        <div class="info-container">
            <h3>{{ $bid->auction->name }}</h3>
            <p>Auctioneer: <a href="{{ route('user', ['id' => $bid->auction->owner_id]) }}">{{ $bid->auction->owner->name }}</a></p>
            <div class="image-container">
                <img src="{{ $bid->auction->owner->img }}" alt="UserImage" width="100" height="100" style="border-radius: 50%;">
            </div>
            <p>Amount: {{ $bid->amount }}</p>
            <p>Date: {{ $bid->date }}</p>
        </div>
    </article>
</a>