<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('tweets/{name?}', 'TweetsController@index')->name('tweets');
Route::get('tweets/done/{name?}', 'TweetsController@done')->name('tweetsDone');
Route::get('stats/{name?}', 'TweetsController@stats')->name('tweetsStats');

Route::post('tweets/update/{name?}', 'TweetsController@update');