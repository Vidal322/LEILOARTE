<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $message;
    public $auction_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($auction_id) {
        $this->auction_id = $auction_id;
        $this->message = 'Auction ' . $auction_id . ' has been canceled';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return 'lbaw23113';
    }

    public function broadcastAs() {
        return 'followed-auction-canceled-notification';
    }
}
