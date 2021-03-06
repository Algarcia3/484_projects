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
Route::get('/', function () {
    return view('home');
});

// resource controllers. fuckin awesome, too lazy to write out my routes
Route::resource('users', 'UsersController');
Route::resource('restaurants', 'RestaurantsController');

// routes associated with loggin in and out of the application.
Route::get('login', array('uses' => 'HomeController@showLogin'));
Route::post('login', array('uses' => 'HomeController@performLogin'));
Route::get('logout', array('uses' => 'HomeController@performLogout'));

// routes associated with user creation, modification, etc.
Route::get('register', array('uses' => 'RegistrationController@showRegistration'));
Route::post('register', array('uses' => 'RegistrationController@performRegistration'));
Route::get('changepassword', 'RegistrationController@showPasswordChange');
Route::post('changepassword', 'RegistrationController@performPasswordChange');

// routes for the main view
Route::get('main', array('uses'	=>	'MainController@showMainPage'));

// routes for the reviews, creation (Restaurants Controller will be handling it)
Route::get('restaurants/{restaurant}/addreview', 'RestaurantsController@showReview');
Route::post('restaurants/{restaurant}/addreview', 'RestaurantsController@createReview');
Route::get('myreviews', 'RestaurantsController@showMyReviews');

// routes for showing user profile
Route::get('myprofile', 'MainController@myProfile');

// creation of restaurant
Route::get('addrestaurant', 'RestaurantsController@showCreate');
Route::post('addrestaurant', 'RestaurantsController@create');

// editing a restaurant, menu items, etc.
Route::get('restaurants/{restaurant}/edit', 'RestaurantsController@showEdit');
Route::post('restaurants/{restaurant}/edit', 'RestaurantsController@edit');
Route::get('restaurants/{restaurant}/addhours', 'RestaurantsController@showAddHours');
Route::post('restaurants/{restaurant}/addhours', 'RestaurantsController@addHours');
Route::get('restaurants/{restaurant}/addmenuitem', 'RestaurantsController@showAddMenuItem');
Route::post('restaurants/{restaurant}/addmenuitem', 'RestaurantsController@addMenuItem');

// routes for the admin panel, promoting and demoting users.
Route::get('admin', 'MainController@adminPanel');
Route::get('demoteuser/{id}', 'MainController@demoteUser');
Route::get('promoteuser/{id}', 'MainController@promoteUser');