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

Route::get('api/rating/insufficient', 'API\RatingController@getInsufficient');
Route::get('api/rating/satisfying', 'API\RatingController@getSatisfying');
Route::get('api/rating/satisfactory', 'API\RatingController@getSatisfactory');
Route::get('api/rating/monthly', 'API\RatingController@getMonthly');
Route::get('api/rating/overall', 'API\RatingController@overall');
Route::get('api/rating/pastSixMonth', 'API\RatingController@pastSixMonth');

Route::get('api/get/tweets', 'API\TwitterController@getTweets');

Route::post('api/get/stations', 'API\TrainInfoController@station');
Route::post('api/get/trainNumbers', 'API\TrainInfoController@trainNumber');

Route::post('api/rating/save', 'API\RatingController@saveRating');
