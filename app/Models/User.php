<?php

namespace App\Models;

use App\Http\Controllers\FileController;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'description', 'password', 'img', 'delected', 'rate', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', //'remember_token',
    ];

    /**
     * The auctions this user owns.
     */
    public function auctions() {
      return $this->hasMany('App\Models\Auction', 'owner_id');
    }

    public function bids() {
      return $this->hasMany('App\Models\Bid');
    }

    public function getProfileImage() {
      return FileController::get('profile', $this->id);
    }

    public function notfications() {
      return $this->hasMany('App\Models\Notification', 'user_id');
    }
}
