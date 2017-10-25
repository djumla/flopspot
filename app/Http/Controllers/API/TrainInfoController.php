<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class TrainInfoController extends Controller
{
    public function station(Request $request)
    {
        return DB::table('train_stations')->where('station', 'like', $request->station.'%')->limit(8)->get();
    }

    public function trainNumber(Request $request)
    {
        return DB::table('train_numbers')->where('trainNumber', 'like', $request->trainNumber.'%')->limit(8)->get();
    }
}
