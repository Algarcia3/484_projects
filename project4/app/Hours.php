<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hours extends Model
{
    // specify primary key
    protected $primaryKey = "hours_id";

    // specifying the actual name of the table
    protected $table = "operating_hours";

    // relation to restaurants
    public function restaurant() {
        return $this->hasOne('App\Restaurant', 'restaurant_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day',
        'time_open',
        'time_closed',
    ];
}
