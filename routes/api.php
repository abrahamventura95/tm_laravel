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


//Auth
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

//User
Route::group([
    'prefix' => 'user'
], function () {
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('all', 'UserController@users');
        Route::get('{id}', 'UserController@show');
        Route::put('{id}', 'UserController@edit');
        Route::delete('{id}', 'UserController@delete');
    });
});


//Money Moves
Route::group([
    'prefix' => 'task'
], function () {
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('', 'TaskController@create');
        Route::get('', 'TaskController@get');
        Route::get('tag/{tag}', 'TaskController@getByTag');
        Route::get('{id}', 'TaskController@show');
        Route::put('{id}', 'TaskController@edit');
        Route::delete('{id}', 'TaskController@delete');
    });
});