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

  public function overall()
  {
    return DB::table('rating_info')->select('rating')->count();
  }

  public function getInsufficient()
  {
    return DB::table('rating_info')->where('rating', '=', 1)->count();
  }

  public function getSatisfying()
  {
    return DB::table('rating_info')->where('rating', '=', 2)->count();
  }

  public function getSatisfactory()
  {
    return DB::table('rating_info')->where('rating', '=', 3)->count();
  }

  public function pastSixMonth() {
    $start = date("n")-6;
    $end = date("n");

    return DB::table('rating_info')->select('rating', 'created_at')->whereMonth('created_at', '>',$start, 'and', '<', $end)->get();
  }
}
