<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;

class HomeController extends Controller
{
    // creating the first function for logging in
    public function showLogin() {
        return \View::make('login');
    }

    public function performLogin() {
        // start off with validation rules
        $rules = array(
            'username' => 'required|alphaNum',
            'password' => 'required|alphaNum',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $user_data = array(
                'username' => Input::get('username'),
                'password' => Input::get('password'),
            );

            if(Auth::attempt($user_data)) {
                echo "successfully authenticated";
            } else {
                Session::flash('message', "Incorrect username or password. Please try again.");
                return Redirect::to("login");
            }
        }

    }

    // perform the logout functionality when clicked
    public function performLogout() {
        
    }

}
