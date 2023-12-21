<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionCategory extends Model
{
    protected $table = "auction_category";
    protected $fillable = ['auction_id', 'category_id'];
    public $timestamps = false;

    public function auction() {
      return $this->belongsTo(Auction::class);
    }

    public function category(){
      return $this->belongsTo(Category::class);
    }
}
