<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
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
        return \App\Station::where('station', 'like', '%'.$request->station.'%')->limit(8)->get();
    }

    /**
     * @param  Request $request
     *
     * @return array
     */
    public function getTrainNumbers(Request $request)
    {
        return \App\TrainNumber::where('trainNumber', 'like', $request->trainNumber.'%')->limit(8)->get();
    }
}
