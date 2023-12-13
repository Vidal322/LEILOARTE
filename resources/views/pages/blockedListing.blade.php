@extends('layouts.app')

@section('content')

<div class="users-list">
  @foreach ($blockedUsers as $user)
  <div class="user-card">
    <p>{{ $user->name}}</p>
    <div class="image-container">
        <img src= "{{ $user->img }}" alt="UserImage" width="100" height="100" style="border-radius: 50%;" >
    </div>
    <form method="POST" action="{{ route('unblockUser', ['id' => $user->id]) }}">
                {{ csrf_field() }}
       <button class="button button-outline"> <a> Unblock </a> </button>
    </form>
  </div>
  @endforeach
</div>


@endsection