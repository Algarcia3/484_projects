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
            return Redirect::to("main");
        } else {
            return \View::make('register');
        }
    }

    public function performRegistration() {
    	// validation rules for registering user.
    	$rules = array(
    		'username'	=>	'required|alphaNum|unique:users',
    		'name'	=>	'required',
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

    		// attach the of reviewer to the default user
    		$new_user->roles()->attach(2);

    		// redirect to the login page, and display account successfully created message
    		Session::flash("acc_created", "Your account has been successfully created. Try logging in!");
    		return Redirect::to("login");
    	}
    }

	public function showPasswordChange() {
		if(Auth::check()) {
            return \View::make('changepassword');
        } else {
            // go back home pls
            return Redirect::to("main");
        }
	}

	public function performPasswordChange() {
		// get current id of user signed in
		$current_user = Auth::user()->user_id;

		// set up validator rules
		$rules = array(
			'old_password'	=>	'required',
			'password'	=>	'required|alphaNum|min:3|confirmed',
    		'password_confirmation' => 'required|alphaNum|min:3',
		);

		// start validator
		$validator = Validator::make(Input::all(), $rules);
		
		// perform the pw change
		if($validator->fails()) {
    		return Redirect::to('changepassword')
    			->withErrors($validator)
    			->withInput(Input::except('old_password','password'));
		} else {
			// retrieve the currently logged in user and compare old_password
			$user = User::findOrFail($current_user);
			$old_password = Input::get("old_password");
			
			// check if the old_password matches their current pass.
			if(Hash::check($old_password, $user->password)) {
				$user->password = Hash::make(Input::get('password'));
				$user->save();
				Session::flash("password_changed", "Password successfully changed.");
				return Redirect::to('changepassword');
			} else {
				// redirect with error message
				return Redirect::to('changepassword')->withErrors("Incorrect password.");
			}
		}
	}
}