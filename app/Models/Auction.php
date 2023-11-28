<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = "auction";
  protected $fillable = [
    'description', 'name', 'image', 'owner_id', 'active', 'starting_price', 'start_t', 'end_t'
  ];

  /**
   * The user this card belongs to
   */
  public function owner() {
    return $this->belongsTo('App\Models\User');
  }

  public function bids() {
    return $this->hasMany('App\Models\Bid');
  }

  public function auctionsSaved() {
    return $this->hasMany('App\Models\AuctionSave', 'auction_id');
  }

}
