<?php

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

Route::prefix('/url-shortner')->group(function () {
    Route::get('/by-user/{userId}', '\App\Http\Controllers\UrlShortnerController@fetchByUser');
    Route::get('/{code}', '\App\Http\Controllers\UrlShortnerController@fetch');
    Route::put('/{code}', '\App\Http\Controllers\UrlShortnerController@update');
    Route::delete('/{code}', '\App\Http\Controllers\UrlShortnerController@delete');
    Route::post('/', '\App\Http\Controllers\UrlShortnerController@create');
});

Route::prefix('/users')->group(function () {
    Route::get('/list', '\App\Http\Controllers\UsersController@fetchAll');
    Route::get('/{id}', '\App\Http\Controllers\UsersController@fetch');
    Route::put('/{id}', '\App\Http\Controllers\UsersController@update');
    Route::delete('/{id}', '\App\Http\Controllers\UsersController@delete');
    Route::post('/', '\App\Http\Controllers\UsersController@create');
});
