<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Station;
use App\TrainNumber;

class TrainInfoController extends Controller
{
    /**
     * @param  Request $request
     *
     * @return array
     */
    public function getStations(Request $request)
    {
        return Station::where('station', 'like', '%' . $request->station . '%')->limit(8)->get();
    }

    /**
     * @param  Request $request
     *
     * @return array
     */
    public function getTrainNumbers(Request $request)
    {
        return TrainNumber::where('trainNumber', 'like', $request->trainNumber . '%')->limit(8)->get();
    }
}
