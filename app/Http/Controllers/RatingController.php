<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class RatingController extends Controller
{
    public function getRating(Request $request)
    {
      /*$rating = DB::table('rating')->select('id')->where('id', '=', $request->rating)->get();

      echo $rating;*/
      return $request;
    }
}
