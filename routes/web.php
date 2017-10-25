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

// Chart routes
Route::get('rating/insufficient', 'API\FlopspotController@getInsufficient');
Route::get('rating/satisfying', 'API\FlopspotController@getSatisfying');
Route::get('rating/satisfactory', 'API\FlopspotController@getSatisfactory');
Route::get('rating/monthly', 'API\FlopspotController@getMonthly');
Route::get('rating/overall', 'API\FlopspotController@overall');
Route::get('rating/pastSixMonth', 'API\FlopspotController@pastSixMonth');

// Tweets route to display those in frontend
Route::get('tweets', 'API\TwitterController@getTweets');

// Routes for the vue.js autocomplete plugin
Route::post('station', 'API\FlopspotController@station');
Route::post('trainNumber', 'API\FlopspotController@trainNumber');

// Frontend form route
Route::post('saveRating', 'API\RatingController@saveRating');
