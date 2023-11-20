@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('editAuction', ['id'=> $id]) }}">
    {{ csrf_field() }}

    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
        <span class="error">
          {{ $errors->first('name') }}
        </span>
    @endif
    
    <label for="img" >Image</label>
    <input id="img" type="file" name="img" required>
    @if ($errors->has('img'))
        <span class="error">
            {{ $errors->first('img') }}
        </span>
    @endif

    <label for="description" >Description</label>
    <input id="description" type="text" name="description" required>
    @if ($errors->has('description'))
        <span class="error">
            {{ $errors->first('description') }}
        </span>
    @endif

    <label for="end_t" >Auction End Date</label>
    <input id="end_t" type="date" name="end_t" required>
    @if ($errors->has('end_t'))
        <span class="error">
            {{ $errors->first('end_t') }}
        </span>
    @endif

    <button type="submit">
        Save
    </button class="button button-outline">
    <a class="button button-outline" href="{{ route('auctions', ['id'=> $id]) }}">Cancel</a>
</form>

@endsection