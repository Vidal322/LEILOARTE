@extends('layouts.app')

@section('content')
    <div class = "content">
        <h1> This is {{$auction->name}} Auction </h1>
        <div> description: {{$auction->description}} </div>
        <div> start date: {{$auction->start_t}} </div>
        <div> end date: {{$auction->end_t}} </div>
        <div> image: {{$auction->image}} </div>
        <div> owner_id: {{$auction->owner_id}} </div>
    </div>
@endsection