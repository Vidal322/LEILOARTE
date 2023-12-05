<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = "bid";

  protected $fillable = [
    'amount', 'date', 'top_bid', 'user', 'auction',
  ];


  /**
   * auction this bid belongs to
   */
  public function auction() {
    return $this->belongsTo('App\Models\Auction');
  }

  /**
   * The user that made the bid
   */
  public function bidder() {
    return $this->belongsTo('App\Models\User', 'user_id');
  }




}
