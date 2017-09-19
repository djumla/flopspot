<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingInfo extends Model
{
  protected $table = 'rating_info';

  protected $fillable = [
    'entrance',
    'exit',
    'trainNumber',
    'rating'
  ];
}
