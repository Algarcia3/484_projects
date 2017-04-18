<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    // specify primary key
    protected $primaryKey = "menu_id";

    // specifying the actual name of the table
    protected $table = "menus";

    // return the relation
    public function restaurant() {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_name', 
        'menu_description', 
        'menu_price',
    ];
}
