@extends('layouts.app')

@section('title', 'Create Bid')

@section('content')
<form method="POST" action="{{ route('createBid', ['id'=> $id]) }}">
    {{ csrf_field() }}

    <label for="amount">Amount</label>
    <input id="amount" type="number" step="0.01" name="amount" value="0" required autofocus>
    @if ($errors->has('amount'))
        <span class="error">
          {{ $errors->first('amount') }}
        </span>
    @endif

    <button type="submit">
        Place Bid
    </button>
    <a class="button button-outline" href="{{ route('auctions', ['id'=> $id]) }}">Cancel</a>
</form>

@endsection