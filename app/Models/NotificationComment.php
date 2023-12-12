<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationComment extends Model
{
    protected $table = "notification_comment";
    public $timestamps = false;

    public function notification() {
        return $this->belongsTo('App\Models\Notification', 'notification_id');
    }

    public function comment() {
        return $this->belongsTo('App\Models\Comment', 'comment_id');
    }

}

