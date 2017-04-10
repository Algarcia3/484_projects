<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	// specify primary key
    protected $primaryKey = "review_id";

    // specifying the actual name of the table
    protected $table = "reviews";

    // return the 
    public function users() {
        return $this->hasOne('App\User');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'user_email', 'user_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password',
    ];

}
