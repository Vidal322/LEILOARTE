<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = "faq";

  protected $fillable = [
    'question', 'answer',
  ];

}
