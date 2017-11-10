<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
      'entrance',
      'exit',
      'trainNumber',
      'date',
      'rating'
    ];
}
