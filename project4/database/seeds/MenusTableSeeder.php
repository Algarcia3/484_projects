<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('menus')->insert([
            'menu_id' => 1,
            'restaurant_id' => 1,
            'item_name' => 'slop',
            'menu_description'	=>	'sounds friggin good',
            'menu_price'	=>	"1.00",
        ]);
    }
}
