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
use App\Review;
use App\Restaurant;

class RestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $restaurants = Restaurant::all();
        return \View::make('restaurants')->with("restaurants", $restaurants);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // variables retrieving
        $restaurants = Restaurant::findOrFail($id);
        $reviews = Review::where('restaurant_id', '=', $id)->get();
        // get the avg rating of course
        $avg_rating = $reviews->avg('rating');
        return \View::make('showrestaurant')
                ->with("restaurants", $restaurants)
                ->with("reviews", $reviews)
                ->with("avg_rating", $avg_rating);
    }

    /**
     * Display the form for creating a review
     *
     */
    public function showReview($id) {
        if(Auth::check()) {
            // pass in the id again from the previous route, so it knows what to do with it
            $restaurants = Restaurant::findOrFail($id);
            return \View::make('addreview')->with("restaurants", $restaurants);
        } else {
            // go back home pls
            return Redirect::to("home");
        }
    }

    public function createReview($id) {
        // again, fetching id of restaurant cus that's what we want
       $restaurants = Restaurant::findOrFail($id);
       $rules = array(
    		'rating'	=>	'required',
    		'title'	=>	'required',
    		'review'	=>	'required',
    	);

    	// kick off validator instance for our registration page
    	$validator = Validator::make(Input::all(), $rules);

    	// check to see if the validator fails
    	if($validator->fails()) {
    		return Redirect::to('restaurants/'. $restaurants->restaurant_id .'/addreview')
    			->withErrors($validator)
    			->withInput();
    	} else {
    		// if validator succeeds, add the user to our database and store their credentials
    		$new_review = new Review;
            // get the ID of the currently logged in user, so we can associate review
            $user = Auth::user();
            $user_id = $user->id;

            $new_review->user_id = Auth::user()->user_id;
    		$new_review->rating = Input::get("rating");
    		$new_review->review_tagline = Input::get("title");
    		$new_review->review = Input::get("review");

            // associate the review with the user and save to db
    		$new_review->restaurant()->associate($id);
            $new_review->save();

    		// redirect to the login page, and display account successfully created message
    		Session::flash("review_created", "Review successfully added");
    		return Redirect::to("restaurants/$id");
    	}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}