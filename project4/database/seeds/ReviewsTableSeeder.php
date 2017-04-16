<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('reviews')->insert([
            'review_id' => 1,
            'restaurant_id' => 1,
            'user_id' => 1,
            'rating'	=>	3,
            'review_tagline'	=>	'FUCK THIS PLACE LOL',
            'review'	=>	"I dont rike it",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
