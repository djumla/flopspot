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

  public function trainNumber(Request $request)
  {
    return DB::table('train_number')->where('trainNumber', 'like', $request->trainNumber.'%')->limit(8)->get();
  }

  public function getInsufficientRating()
  {
    return DB::table('rating_info')->where('rating', '=', 1)->count();
  }

  public function getSatisfyingRating()
  {
    return DB::table('rating_info')->where('rating', '=', 2)->count();
  }

  public function getSatisfactoryRating()
  {
    return DB::table('rating_info')->where('rating', '=', 3)->count();
  }
}
