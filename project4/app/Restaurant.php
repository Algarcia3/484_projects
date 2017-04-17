<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    // specify primary key
    protected $primaryKey = "restaurant_id";

    // specifying the actual name of the table
    protected $table = "restaurants";

    // return the relation
    public function reviews() {
        return $this->hasMany('App\Review', 'review_id');
    }

    public function menu_items() {
        return $this->hasMany('App\Menu', 'menu_id');
    }

    public function operating_hours() {
        return $this->hasMany('App\Hours', 'hours_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'restaurant_name', 
        'street_address', 
        'city',
        'state',
        'website',
    ];
}
