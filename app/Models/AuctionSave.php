<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AuctionSave extends Model
{
    protected $table = "auction_save";
    public $timestamps = false;
    protected $primaryKey = ['user_id', 'auction_id'];
    public $incrementing = false;

    public function user() {
      return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function auction() {
        return $this->belongsTo('App\Models\Auction', 'auction_id');
    }
}
