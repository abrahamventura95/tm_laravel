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

//Tasks
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

//Subtasks
Route::group([
    'prefix' => 'subtask'
], function () {
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('{id}', 'TaskController@createSub');
        Route::put('{id}', 'TaskController@editSub');
        Route::delete('{id}', 'TaskController@deleteSub');
    });
});

//Appointments
Route::group([
    'prefix' => 'apmnt'
], function () {
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('', 'AppointController@create');
        Route::get('', 'AppointController@get');
        Route::get('tag/{tag}', 'AppointController@getByTag');
        Route::get('{id}', 'AppointController@show');
        Route::put('{id}', 'AppointController@edit');
        Route::delete('{id}', 'AppointController@delete');
    });
});

//Habits
Route::group([
    'prefix' => 'habit'
], function () {
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('', 'HabitController@create');
        Route::get('', 'HabitController@get');
        Route::get('tag/{tag}', 'HabitController@getByTag');
        Route::get('{id}', 'HabitController@show');
        Route::put('{id}', 'HabitController@edit');
        Route::delete('{id}', 'HabitController@delete');
    });
});

//Habits Day
Route::group([
    'prefix' => 'day'
], function () {
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('{id}', 'HabitController@createDay');
        Route::put('{id}', 'HabitController@editDay');
        Route::delete('{id}', 'HabitController@deleteDay');
    });
});