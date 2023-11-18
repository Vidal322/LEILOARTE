<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = "auction";
  protected $fillable = [
    'description', 'owner_id', 'active', 'start', 'end', 'name',
  ];
  
  /**
   * The user this card belongs to
   */
  public function owner() {
    return $this->belongsTo('App\Models\User');
  }

  /**
   * Items inside this card
   */
  public function category() {
    return $this->belongsTo('App\Models\Category');
  }
  
  public function bids() {
    return $this->hasMany('App\Models\Bid', 'auction_id');
  }


}
