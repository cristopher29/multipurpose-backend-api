<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'landing');
Route::match(['get', 'post'], '/dashboard', function(){
    return view('dashboard');
});
Route::view('/examples/plugin-helper', 'examples.plugin_helper');
Route::view('/examples/plugin-init', 'examples.plugin_init');
Route::view('/examples/blank', 'examples.blank');


Route::any('/dashboard/users', 'Web\UsersController@users')->name('dashboard.users');
Route::post('/login', 'Web\AuthController@login')->name('login');
Route::get('/login', 'Web\AuthController@showLogin')->name('showLogin');
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
