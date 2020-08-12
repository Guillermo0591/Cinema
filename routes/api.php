<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', 'JWTAuthController@register');
    Route::post('login', 'JWTAuthController@login');
    Route::post('logout', 'JWTAuthController@logout');
    Route::post('refresh', 'JWTAuthController@refresh');

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'movie'
], function ($router) {
    Route::get('index', 'MovieController@index');
    Route::post('store', 'MovieController@store');
    Route::post('assing', 'MovieController@assingMovieToTurn');
    Route::get('show/{id}', 'MovieController@show');
    Route::put('update/{id}', 'MovieController@update');
    Route::delete('destroy/{id}', 'MovieController@destroy');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'turn'
], function ($router) {
    Route::get('index', 'TurnController@index');
    Route::post('store', 'TurnController@store');
    Route::get('show/{id}', 'TurnController@show');
    Route::put('update/{id}', 'TurnController@update');
    Route::delete('destroy/{id}', 'TurnController@destroy');
});
