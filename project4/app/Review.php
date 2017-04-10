<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	// specify primary key
    protected $primaryKey = "review_id";

    // specifying the actual name of the table
    protected $table = "reviews";

    // return the relations
    public function user() {
        return $this->hasOne('App\User', 'user_id');
    }

    public function restaurant() {
        return $this->hasOne('App\Restaurant', 'restaurant_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating', 'review_tagline', 'review',
    ];
}
