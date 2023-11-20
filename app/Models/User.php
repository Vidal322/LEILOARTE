<?php

namespace App\Models;

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
     * The cards this user owns.
     */
    public function posts() {
      return $this->hasMany('App\Models\Auction', 'owner_id');
    }
    public function bids() {
      return $this->hasMany('App\Models\Bid', 'user_id');
    }
}
