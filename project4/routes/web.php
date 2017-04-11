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

// replaced laravel landing page with simple home page
Route::get('home', function () {
    return view('home');
});

// resource controllers. fuckin awesome, too lazy to write out my routes
Route::resource('users', 'UsersController');

// routes associated with loggin in and out of the application.
Route::get('login', array('uses' => 'HomeController@showLogin'));

Route::get('logout', array('uses' => 'HomeController@performLogout'));

Route::post('login', array('uses' => 'HomeController@performLogin'));

Route::group(['before' => 'auth'], function()
{
    //define all routes here that need to be auth'd
    Route::get('login', array('uses' => 'HomeController@showLogin'));
});