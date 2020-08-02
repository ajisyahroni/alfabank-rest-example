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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'UserController@login')->name('login');
Route::post('/register', 'UserController@register')->name('register');
Route::post('/logout', 'UserController@logout')->name('logout')->middleware('auth:api');

Route::group(['prefix' => 'v1'], function () {
    Route::get('/blogs/all', 'BlogController@index')->middleware('cors');

    // tweets
    Route::group(['prefix' => 'tweets'], function () {
        Route::get('/all', 'TweetController@index')->middleware('cors');
        Route::post('/create', 'TweetController@create')->middleware(['auth:api', 'cors']);
        Route::put('/update/{id}', 'TweetController@update')->middleware(['auth:api', 'cors']);
        Route::delete('/delete/{id}', 'TweetController@destroy')->middleware(['auth:api', 'cors']);
    });
});
