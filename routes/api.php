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

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

Route::group(['prefix' => 'v1'], function () {
    Route::get('/', 'Api\V1\HomeController@index');

    Route::get('players', 'Api\V1\PlayerController@show');
    Route::post('players/create', 'Api\V1\PlayerController@create');

    Route::get('games', 'Api\V1\GameController@index');
});
