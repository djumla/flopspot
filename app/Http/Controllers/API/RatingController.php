<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Rating;

class RatingController extends Controller
{
    /**
     * @return array
     */
    public function total()
    {
        return DB::table('ratings')->select('rating')->count();
    }

    /**
     * @return array
     */
    public function getInsufficient()
    {
        //return $model->where('rating', '=', 1)->count();
        return DB::table('ratings')->where('rating', '=', 1)->count();
    }

    /**
     * @return array
     */
    public function getSatisfying(/*RatingInfo $model*/)
    {
        return DB::table('ratings')->where('rating', '=', 2)->count();
    }

    /**
     * @return array
     */
    public function getSatisfactory()
    {
        return DB::table('ratings')->where('rating', '=', 3)->count();
    }

    /**
     * @return array
     */
    public function pastSixMonth()
    {
        $start = date("n")-6;
        $end = date("n");

        $insufficient = DB::table('ratings')->select('rating')->whereMonth('created_at', '>', $start, 'and', '<', $end)->where('rating', '=', 1)->count();
        $satisfying = DB::table('ratings')->select('rating')->whereMonth('created_at', '>', $start, 'and', '<', $end)->where('rating', '=', 2)->count();
        $satisfactory = DB::table('ratings')->select('rating')->whereMonth('created_at', '>', $start, 'and', '<', $end)->where('rating', '=', 3)->count();

        /**
          * Every value has a specific key. (insufficient => $insufficient)
          * This is done because this data will be used for chart.js
          * To speed this up, chart.js needs some values to generate their chart.
          * And finally, to know which part of the value will be represented of the chart, every value has a key to identify.
        */
        $ratings = array("insufficient" => $insufficient, "satisfying" => $satisfying, "satisfactory" => $satisfactory);

        return $ratings;
    }

    /**
     * Called when form was submitted in frontend
     *
     * @param  Request $request
     *
     * @return void
     */
    public function store(Request $request)
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
