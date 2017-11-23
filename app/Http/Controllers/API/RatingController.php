<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RatingController extends Controller
{
    /**
     * @return array
     */
    public function total()
    {
        return Rating::select('rating')->count();
    }

    /**
     * @return array
     */
    public function getInsufficient()
    {
        return Rating::where('rating', '=', 1)->count();
    }

    /**
     * @return array
     */
    public function getSatisfying()
    {
        return Rating::where('rating', '=', 2)->count();
    }

    /**
     * @return array
     */
    public function getSatisfactory()
    {
        return Rating::where('rating', '=', 3)->count();
    }

    /**
     * @param \App\Rating
     *
     * @return array
     */
    public function pastSixMonth(Rating $ratingModel)
    {
        return $ratingModel->getCombinedRatings(date("n") - 6, date("n"));
    }

    /**
     * Called when form was submitted in frontend
     *
     * @param  Requests\StoreRating $request
     *
     * @return void|Response
     */
    public function store(Requests\StoreRating $request)
    {
        $entrance = Station::where('station', '=', $request->entrance)->first();
        $exit = Station::where('station', '=', $request->exit)->first();
        $trainNumber = TrainNumber::where('trainNumber', '=', $request->trainNumber)->first();

        $rating = new Rating;
        $rating->entrance = $entrance->id;
        $rating->exit = $exit->id;
        $rating->trainNumber = $trainNumber->id;
        $rating->date = $request->date;
        $rating->rating = $request->rating;

        $rating->save();
    }
    /*
     * TODO: Make this function great again!
     */
    public function getTrackSection(Rating $ratingModel)
    {
        return $ratingModel->getEquallySections();
    }

    /*
     * Search for a specific track and get its rating!
     * Currently working on.
     */
    public function getUserSpecificSection(Rating $ratingModel, Request $request)
    {
        return $ratingModel->getStationRatings($request);
    }
}
