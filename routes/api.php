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

Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('register', 'AuthController@register')->name('register');
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');

        Route::post('parseStore', 'StoreController@parseStore')->name('parseStore');
        Route::post('createStore', 'StoreController@createStore')->name('createStore');

    });

    Route::group(['middleware' => 'jwt.auth'], function () {

        Route::post('test', 'TestController@test')->name('test');
        Route::get('getStores', 'StoreController@getStores')->name('getStores');
    });

});
