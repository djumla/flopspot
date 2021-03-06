<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/statistic', function () {
    return view('/layouts/statistics');
});

Route::get('/contact', function () {
    return view('/layouts/contact');
});

// RatingController
Route::get('api/rating/insufficient', 'API\RatingController@getInsufficient');
Route::get('api/rating/satisfying', 'API\RatingController@getSatisfying');
Route::get('api/rating/satisfactory', 'API\RatingController@getSatisfactory');
Route::get('api/rating/total', 'API\RatingController@total');
Route::get('api/rating/pastSixMonth', 'API\RatingController@pastSixMonth');
Route::post('api/rating/save', 'API\RatingController@store');

// TwitterController
Route::get('api/tweets', 'API\TwitterController@getTweets');

// TrainInfoController
Route::post('api/stations', 'API\TrainInfoController@getStations');
Route::post('api/trainNumbers', 'API\TrainInfoController@getTrainNumbers');