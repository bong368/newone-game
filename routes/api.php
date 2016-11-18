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

    Route::get('players/{username}', 'Api\V1\PlayerController@show');
    Route::post('players/create', 'Api\V1\PlayerController@create');
    Route::post('players/{username}/update', 'Api\V1\PlayerController@update');
    Route::post('players/{username}/refresh-access-token', 'Api\V1\PlayerController@refreshAccessToken');

    Route::get('transactions', 'Api\V1\TransactionController@index');
    Route::get('transactions/{transaction_no}', 'Api\V1\TransactionController@show');
    Route::post('transactions/inward', 'Api\V1\TransactionController@inward');
    Route::post('transactions/outward', 'Api\V1\TransactionController@outward');

    Route::get('games', 'Api\V1\GameController@index');
    Route::get('games/{name}', 'Api\V1\GameController@show');
});
