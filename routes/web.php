<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    li()->info(GameCategory::getConstants());
    li()->info(GameCategory::getNames());
    li()->info(GameCategory::getValues());
    li()->info(implode(',', \GameCategory::getNames()));

    $games = \App\Models\App::find(1)->games()->get();
    li()->info($games);

    return view('welcome');
});

Route::get('play/{name}/{access_token}', 'PlayController@index');

//Route::get('play/legacy/{name}', 'PlayController@legacy');
//Route::get('play/avslot/{name}', 'PlayController@avslot');
