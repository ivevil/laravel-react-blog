<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'App\Http\Controllers\Auth'], function()
{
    Route::group(['middleware' => ['guest']], function() {
    /**
     * Register Routes
     */
    Route::get('/register', 'RegisterController@show')->name('register');
    Route::post('/register', 'RegisterController@register')->name('register.perform');

    /**
     * Login Routes
     */
    Route::get('/login', 'LoginController@show')->name('login');
    Route::post('/login', 'LoginController@login')->name('login.perform');

    /**
    * Reset passwords
    */
    Route::get('/pass-reset', 'ResetPasswordController@reset')->name('passwords.reset');

  });

  Route::group(['middleware' => ['auth']], function() {
      /**
       * Logout Routes
       */
       Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
  });
});