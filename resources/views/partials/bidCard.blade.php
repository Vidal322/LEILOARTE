<div class="info-container">
    <h3 class="title"> {{$bid->auction->name}}</h3>
    <p class="bid amount">Amount: {{ $bid->amount }} </p>
    <p>Date: {{ substr($bid->date,0,-3)}}</p>
</div>
