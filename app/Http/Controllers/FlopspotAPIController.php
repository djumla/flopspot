<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class FlopspotAPIController extends Controller
{
  public function stations()
  {
    return DB::table('train_station')->select('station')->get();
  }

  public function trainName()
  {
    return DB::table('train_name')->select('name')->get();
  }
}
