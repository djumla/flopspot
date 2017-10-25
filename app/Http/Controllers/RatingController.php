<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\RatingInfo;

class RatingController extends Controller
{
    // Called when form was submitted in frontend
    public function saveRating(Request $request)
    {
        $rating = DB::table('rating')->where('id', '=', $request->rating)->first();
        $entrance = DB::table('train_station')->where('station', '=', $request->entrance)->first();
        $exit = DB::table('train_station')->where('station', '=', $request->exit)->first();
        $trainNumber = DB::table('train_number')->where('trainNumber', '=', $request->trainNumber)->first();

        $ratingInfo = new RatingInfo;

        $ratingInfo->entrance = $entrance->id;
        $ratingInfo->exit = $exit->id;
        $ratingInfo->trainNumber = $trainNumber->id;
        $ratingInfo->rating = $rating->id;

        $ratingInfo->save();
    }
}
