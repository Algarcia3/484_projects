<?php

use Illuminate\Database\Seeder;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('restaurants')->insert([
            'restaurant_id' => 1,
            'restaurant_name' => "Jayne's Slop n Biscuits",
            'street_address' => '1409 Cranberry Ln.',
            'city'	=>	'Harris Bluffs',
            'state'	=>	'California',
            'website'	=>	'google.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
