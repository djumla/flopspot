<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\RatingInfo;

class RatingController extends Controller
{
    public function saveRating(Request $request)
    {
      $entranceID;
      $exitID;
      $ratingID;
      $trainNumberID;

      $rating = DB::table('rating')->where('id', '=', $request->rating)->get();
      $entrance = DB::table('train_station')->where('station', '=', $request->entrance)->get();
      $exit = DB::table('train_station')->where('station', '=', $request->exit)->get();
      $trainNumber = DB::table('train_number')->where('trainNumber', '=', $request->trainNumber)->get();

      foreach($rating as $rtng) {
        $ratingID = $rtng->id;
        echo $ratingID;
      }

      foreach($entrance as $entrnc) {
        $entranceID = $entrnc->id;
      }

      foreach($exit as $ext) {
        $exitID = $ext->id;
      }

      foreach($trainNumber as $number) {
        $trainNumberID = $number->id;
      }

      $ratingInfo = new RatingInfo;

      $ratingInfo->entrance = $entranceID;
      $ratingInfo->exit = $exitID;
      $ratingInfo->trainNumber = $trainNumberID;
      $ratingInfo->rating = $ratingID;

      $ratingInfo->save();
    }
}
