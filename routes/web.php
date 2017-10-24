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
Route::get('rating/insufficient', 'API\FlopspotController@getInsufficient');
Route::get('rating/satisfying', 'API\FlopspotController@getSatisfying');
Route::get('rating/satisfactory', 'API\FlopspotController@getSatisfactory');
Route::get('rating/monthly', 'API\FlopspotController@getMonthly');
Route::get('rating/overall', 'API\FlopspotController@overall');
Route::get('rating/pastSixMonth', 'API\FlopspotController@pastSixMonth');
Route::get('tweets', 'API\TwitterController@getTweets');
Route::post('station', 'API\FlopspotController@station');
Route::post('trainNumber', 'API\FlopspotController@trainNumber');
Route::post('saveRating', 'API\RatingController@saveRating');
Route::get('imprint', 'PageController@imprint');
