<a href="/auctions/{{ $auction->id }}"><article class="auction_card">
  <div class="auction-card">
      <div class="image-container">
        <img src="{{ $auction->image }}" alt="AuctionImage">
      </div>
      <div class="info-container">
        <h3>{{ $auction->name }}</h3>
        <p>By: {{ $auction->owner_id }}</p>
        <p>{{ $auction->description }}</p>
      </div>
    </div>
</article></a>