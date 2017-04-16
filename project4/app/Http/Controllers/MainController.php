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

class MainController extends Controller
{
    //
    public function showMainPage() {
    	if(Auth::check()) {
            return \View::make('main');
        } else {
            return Redirect::to('login');
        }
    }

    public function myProfile() {
        if(Auth::check()) {
            // pass the id of the currently logged in user to the query
            $user_profiles = User::where('user_id', '=', Auth::user()->user_id)->get();
            return \View::make('myprofile')->with("user_profiles", $user_profiles);
        } else {
            // go back home pls
            return Redirect::to("home");
        }
    }
}
