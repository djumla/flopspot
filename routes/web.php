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
Route::get('/statistics', function () {
    return view('/layouts/statistics');
});
Route::get('getInsufficientRating', 'FlopspotAPIController@getInsufficientRating');
Route::get('getSatisfyingRating', 'FlopspotAPIController@getSatisfyingRating');
Route::get('getSatisfactoryRating', 'FlopspotAPIController@getSatisfactoryRating');
Route::post('station', 'FlopspotAPIController@station');
Route::post('trainNumber', 'FlopspotAPIController@trainNumber');
Route::post('saveRating', 'RatingController@saveRating');
Route::post('test', 'RatingController@test');
