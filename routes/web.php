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
})->middleware('auth:web');

Route::view('/examples/plugin-helper', 'examples.plugin_helper');
Route::view('/examples/plugin-init', 'examples.plugin_init');
Route::view('/examples/blank', 'examples.blank');


Route::any('/dashboard/users', 'Web\UsersController@users')->name('dashboard.users');
//Route::post('/login', 'Web\AuthController@login')->name('login');
//Route::get('/login', 'Web\AuthController@showLogin')->name('showLogin');

Route::get('login', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Web\Auth\LoginController@login');
Route::post('logout', 'Web\Auth\LoginController@logout')->name('logout');

Route::get('register', 'Web\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Web\Auth\RegisterController@register');

Route::get('password/reset', 'Web\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Web\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Web\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email verification
Route::get('email/verify', 'Web\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Web\Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Web\Auth\VerificationController@resend')->name('verification.resend');

//Route::get('/home', 'HomeController@index')->name('home');
