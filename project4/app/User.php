<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // specify primary key
    protected $primaryKey = "user_id";

    // specifying that my table is called "users"
    protected $table = "users";

    // specify the foreign key, since we're using a custom one
    public function reviews() {
        return $this->hasMany('App\Review', 'review_id');
    }

    // specify the many to many relation
    public function roles() {
        return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
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
