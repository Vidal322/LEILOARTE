<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationAuction extends Model
{
    protected $table = "notification_auction";
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'auction_id', 'message', 'seen',
    ];

    protected $primaryKey = 'notification_id';

    public function notification() {
        return $this->belongsTo('App\Models\Notification', 'notification_id');
    }

    public function auction() {
    return $this->belongsTo('App\Models\Auction', 'auction_id');
    }
}
