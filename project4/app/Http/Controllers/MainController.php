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
            return Redirect::to("main");
        }
    }

    public function adminPanel() {
        if(Auth::user() && Auth::user()->isAdmin()) {
            $all_users = User::all();
            return \View::make("admin")->with("all_users", $all_users);
        } else {
            return Redirect::to("main");
        }
    }

    public function demoteUser($id) {
        if(Auth::user() && Auth::user()->isAdmin()) {
            $user = User::findOrFail($id);
            // since there's only two roles, I decided to ghetto rig it and just do it this way.
            // I know there's a better way.... but I won't.
            $user->roles()->detach(1);
            $user->roles()->attach(2);
            $user->save();
            
            // flash the message that the demotion was successful
            Session::flash("demote_success", "User has been demoted.");
            return Redirect::to("admin");
        }
    }

    public function promoteUser($id) {
        // just do the inverse here of the previous function. ez pz
        if(Auth::user() && Auth::user()->isAdmin()) {
            $user = User::findOrFail($id);
            // since there's only two roles, I decided to ghetto rig it and just do it this way.
            // I know there's a better way.... but I won't.
            $user->roles()->detach(2);
            $user->roles()->attach(1);
            $user->save();
            
            // flash the message that the demotion was successful
            Session::flash("promote_success", "User has been promoted.");
            return Redirect::to("admin");
        }
    }
}
