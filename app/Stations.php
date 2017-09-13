<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stations extends Model
{
    protected $table = 'train_station';

    protected $fillable = [
      'station'
    ];

    public function trainInfo()
   {
       return $this->belongsTo('App\TrainInfo');
   }
}
