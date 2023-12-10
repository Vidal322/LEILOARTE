<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = "block";
  protected $fillable = [
    'blocker_id', 'blocked_id'
  ];

  public static function isBlocked($blockerId, $blockedId)
{
    return self::where('blocker_id', $blockerId)
                ->where('blocked_id', $blockedId)
                ->exists();
}

public function blockedUser()
    {
        return $this->belongsTo(User::class, 'blocked_id');
    }


}