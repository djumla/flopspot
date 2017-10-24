<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class FlopspotController extends Controller
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

    $insufficient = DB::table('rating_info')->select('rating')->whereMonth('created_at', '>',$start, 'and', '<', $end)->where('rating', '=', 1)->count();
    $satisfying = DB::table('rating_info')->select('rating')->whereMonth('created_at', '>',$start, 'and', '<', $end)->where('rating', '=', 2)->count();
    $satisfactory = DB::table('rating_info')->select('rating')->whereMonth('created_at', '>',$start, 'and', '<', $end)->where('rating', '=', 3)->count();

    $rating = array("insufficient" => $insufficient, "satisfying" => $satisfying, "satisfactory" => $satisfactory);

    return $rating;
  }
}
