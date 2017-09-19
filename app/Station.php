<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'train_station';

    protected $fillable = [
      'station'
    ];
}
