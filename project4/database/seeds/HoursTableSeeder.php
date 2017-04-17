<?php

use Illuminate\Database\Seeder;

class HoursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('operating_hours')->insert([
            'hours_id' => 1,
            'restaurant_id' => 1,
            'day' => 'Monday',
            'time_open'	=>	'08:00',
            'time_closed'	=>	"22:00",
        ]);
    }
}
