<a href="{{route('auctions', ['id' => $auction->id])}}"><article class="auction_card">

  <div class="auction-card">
      <div class="image-container">
        <img src="{{ $auction->image }}" alt="AuctionImage">
      </div>
      <div class="info-container">
        <h3>{{ $auction->name }}</h3>
        <?php $user = \App\Http\Controllers\UserController::returnUser($auction->owner_id); ?>
        <p>Auctioneer: <a href="{{route('user', ['id' => $user->id])}}">{{ $user->name }}</a></p>
        <div class="image-container"> 
          <img src= "{{ $user->img }}" alt="UserImage" width="100" height="100" style="border-radius: 50%;" >
      </div>
        <p>{{ $auction->description }}</p>
        
      </div>
    </div>
</article></a>