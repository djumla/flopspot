<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\RatingInfo;

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

    public function getSatisfactory(RatingInfo $model)
    {
        return DB::table('rating_info')->where('rating', '=', 3)->count();
    }

    public function pastSixMonth(RatingInfo $model)
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
