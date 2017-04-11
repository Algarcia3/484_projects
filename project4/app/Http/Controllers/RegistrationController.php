<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Auth;
use Session;
use App\User;

class RegistrationController extends Controller
{
    //
    public function showRegistration() {
    	if(Auth::check()) {
            return Redirect::to("home");
        } else {
            return \View::make('register');
        }
    }

    public function performRegistration() {
    	// validation rules for registering user.
    	$rules = array(
    		'username'	=>	'required|alphaNum|unique:users',
    		'name'	=>	'required|alphaNum',
    		'email'	=>	'unique:users,email',
    		'password'	=>	'required|alphaNum|min:3|confirmed',
    		'password_confirmation' => 'required|alphaNum|min:3',
    	);

    	// kick off validator instance for our registration page
    	$validator = Validator::make(Input::all(), $rules);

    	// check to see if the validator fails
    	if($validator->fails()) {
    		return Redirect::to('register')
    			->withErrors($validator)
    			->withInput(Input::except('password'));
    	} else {
    		// if validator succeeds, add the user to our database and store their credentials
    		$new_user = new User;
    		$password = Input::get("password");
    		$hashed_pw = Hash::make($password);

    		$new_user->username = Input::get("username");
    		$new_user->name = Input::get("name");
    		$new_user->email = Input::get("email");
    		$new_user->password = $hashed_pw;

    		$new_user->save();

    		// attach the role to the user
    		$new_user->roles()->attach(1);

    		// redirect to the login page, and display account successfully created message
    		Session::flash("acc_created", "Your account has been successfully created. Try logging in!");
    		return Redirect::to("login");
    	}
    }
}
