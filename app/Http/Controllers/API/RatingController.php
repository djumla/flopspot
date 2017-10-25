<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Rating;

class RatingController extends Controller
{
    public function overall()
    {
        return DB::table('rating_info')->select('rating')->count();
    }

    public function getInsufficient()
    {
        //return $model->where('rating', '=', 1)->count();
        return DB::table('rating_info')->where('rating', '=', 1)->count();
    }

    public function getSatisfying(/*RatingInfo $model*/)
    {
        return DB::table('rating_info')->where('rating', '=', 2)->count();
    }

    public function getSatisfactory()
    {
        return DB::table('rating_info')->where('rating', '=', 3)->count();
    }

    public function pastSixMonth()
    {
        $start = date("n")-6;
        $end = date("n");

        $insufficient = DB::table('rating_info')->select('rating')->whereMonth('created_at', '>', $start, 'and', '<', $end)->where('rating', '=', 1)->count();
        $satisfying = DB::table('rating_info')->select('rating')->whereMonth('created_at', '>', $start, 'and', '<', $end)->where('rating', '=', 2)->count();
        $satisfactory = DB::table('rating_info')->select('rating')->whereMonth('created_at', '>', $start, 'and', '<', $end)->where('rating', '=', 3)->count();

        /**
          * Every value has a specific key. (insufficient => $insufficient)
          * This is done because this data will be used for chart.js
          * To speed this up, chart.js needs some values to generate their chart.
          * And finally, to know which part of the value will be represented of the chart, every value has a key to identify.
        */
        $rating = array("insufficient" => $insufficient, "satisfying" => $satisfying, "satisfactory" => $satisfactory);

        return $rating;
    }

    // Called when form was submitted in frontend
    public function saveRating(Request $request)
    {
        // TODO: FIRST VALIDATE FORM AND CHECK RATING
        $entrance = DB::table('train_stations')->where('station', '=', $request->entrance)->first();
        $exit = DB::table('train_stations')->where('station', '=', $request->exit)->first();
        $trainNumber = DB::table('train_numbers')->where('trainNumber', '=', $request->trainNumber)->first();

        $rating = new Rating;
        $rating->entrance = $entrance->id;
        $rating->exit = $exit->id;
        $rating->trainNumber = $trainNumber->id;
        $rating->rating = $request->rating; // CHANGE THIS

        $rating->save();
    }
}
