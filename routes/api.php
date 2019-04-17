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

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
Route::post('refresh', 'Api\AuthController@refresh');
Route::post('me', 'Api\AuthController@me');

//Route::middleware('jwt.auth')->get('/user', function (Request $request) {
//    return auth('api')->user();
//});


