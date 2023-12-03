<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps  = false;
    protected $table = "notifications";
    protected $fillable = [
        'user_id', 'message', 'seen',
    ];

    public function user() {
      return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function notificationAuctions() {
      return $this->hasMany('App\Models\NotificationAuction', 'notification_id');
    }

    public function notificationBids() {
        return $this->hasMany('App\Models\NotificationBid', 'notification_id');
    }

    public function notificationComments() {
        return $this->hasMany('App\Models\NotificationComment', 'notification_id');
    }

}

