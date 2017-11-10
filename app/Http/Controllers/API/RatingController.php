<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Rating;
use App\Station;
use App\TrainNumber;

class RatingController extends Controller
{
    /**
     * @return array
     */
    public function total()
    {
        return \App\Rating::select('rating')->count();
    }

    /**
     * @return array
     */
    public function getInsufficient()
    {
        return \App\Rating::where('rating', '=', 1)->count();
    }

    /**
     * @return array
     */
    public function getSatisfying()
    {
        return \App\Rating::where('rating', '=', 2)->count();
    }

    /**
     * @return array
     */
    public function getSatisfactory()
    {
        return \App\Rating::where('rating', '=', 3)->count();
    }

    /**
     * @return array
     */
    public function pastSixMonth()
    {
        $start = date("n")-6;
        $end = date("n");

        $insufficient = \App\Rating::select('rating')->whereMonth('created_at', '>', $start, 'and', '<', $end)->where('rating', '=', 1)->count();
        $satisfying = \App\Rating::select('rating')->whereMonth('created_at', '>', $start, 'and', '<', $end)->where('rating', '=', 2)->count();
        $satisfactory = \App\Rating::select('rating')->whereMonth('created_at', '>', $start, 'and', '<', $end)->where('rating', '=', 3)->count();

        /**
          * Every value in $ratings has a specific key. (insufficient => $insufficient)
          * This is done because this data will be used for chart.js
          * To speed this up, chart.js needs some values to generate their chart.
          * And finally, to know which part of the value will be represented on the chart, every value has a key to identify.
        */
        $ratings = array("insufficient" => $insufficient, "satisfying" => $satisfying, "satisfactory" => $satisfactory);

        return $ratings;
    }

    /**
     * Called when form was submitted in frontend
     *
     * @param  Request $request
     *
     * @return void|Response
     */
    public function store(Requests\StoreRating $request)
    {
        $entrance = \App\Station::where('station', '=', $request->entrance)->first();
        $exit = \App\Station::where('station', '=', $request->exit)->first();
        $trainNumber = \App\TrainNumber::where('trainNumber', '=', $request->trainNumber)->first();

        $rating = new Rating;
        $rating->entrance = $entrance->id;
        $rating->exit = $exit->id;
        $rating->trainNumber = $trainNumber->id;
        $rating->date = $request->date;
        $rating->rating = $request->rating;

        $rating->save();
    }
}
