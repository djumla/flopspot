<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainNumber extends Model
{
    protected $table = 'train_number';

    protected $fillable = [
      'trainNumber'
    ];
}
