<div class="notification-card">
    <div class="notification-info">
        <div class="notification-title">
            <h2><div class="underline-text"> {{$notification->title}} </div></h2>
        </div>
        <div class="notification-message">
            <div>{{$notification->message}}</div>
        </div>
        <div class="notification-date">
            <div>{{$notification->date}}</div>
        </div>
    </div>
    <div class="notification-buttons">
        <form method="POST" action="{{ route('deleteNotification', ['id' => $notification->id]) }}">
            {{ csrf_field() }}
            <button class="button button-outline" type = sumbit>Delete</button>
        </form>
    </div>
</div>
