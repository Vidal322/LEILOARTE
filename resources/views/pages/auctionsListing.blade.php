@extends('layouts.app')

@section('content')
<div class="auctions_list">
  @foreach ($auctions as $auction)
    {{ $auction-> name }}
    <br>
    {{ $auction-> description }}
    <br>
    <br>
  @endforeach
</div>
@endsection
