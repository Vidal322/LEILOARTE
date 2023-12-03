<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationBid extends Model
{
    protected $table = "notification_bid";
    protected $timestamps = false;

    public function notification() {
        return $this->belongsTo('App\Models\Notification', 'notification_id');
    }

    public function bid() {
        return $this->belongsTo('App\Models\Bid', 'bid_id');
    }

}

