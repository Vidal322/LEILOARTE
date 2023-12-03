@extends('layouts.app')
@section('content')
    <div class ="notifications-list">

        @if ($notifications->isEmpty())
            <h2><div class="underline-text"> No notifications to show </div></h2>
        @endif
        @foreach ($notifications as $notification)
            @include('partials.notificationCard', ['notification' => $notification])
        @endforeach
    </div>
@endsection
