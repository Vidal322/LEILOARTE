@include ('partials.auctionCard', ['auction' => $bid->auction])

<div class="info-container">
    <p>Amount: {{ $bid->amount }} </p>
    <p>Date: {{ $bid->date }}</p>

</div>
