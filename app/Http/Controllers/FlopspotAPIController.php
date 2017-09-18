<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class FlopspotAPIController extends Controller
{

  public function station(Request $request)
  {
    return DB::table('train_station')->where('station', 'like', $request->station.'%')->limit(8)->get();
  }

  public function trainName(Request $request)
  {
    return DB::table('train_name')->where('name', 'like', $request->name.'%')->limit(8)->get();
  }
}
