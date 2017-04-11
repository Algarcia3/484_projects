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

Route::post('login', array('uses' => 'HomeController@performLogin'));

Route::get('logout', array('uses' => 'HomeController@performLogout'));

// routes associated with user creation.

Route::get('register', array('uses' => 'RegistrationController@showRegistration'));

Route::post('register', array('uses' => 'RegistrationController@performRegistration'));
