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
    public function pastSixMonth(\App\Rating $model)
    {
        return $model->getCombinedRatings(date("n") - 6, date("n"));
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

    public function reCaptchaHandler(Request $request)
    {
        $client = new \GuzzleHttp\Client();

        $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => env('RECAPTCHA_SECRET'),
                'response' => $request->response
            ]
        ]);

        return $res->getBody();
    }
}
