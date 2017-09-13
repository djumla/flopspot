<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainNames extends Model
{
    protected $table = 'train_name';

    protected $fillable = [
      'name'
    ];

    public function trainInfo()
   {
       return $this->belongsTo('App\TrainInfo');
   }
}
