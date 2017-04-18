<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'user_id' => 1,
            'username' => 'matt',
            'name' => 'Matthew Fritz',
            'email'	=>	'mfritz@darpa.gov',
            'password'	=>  Hash::make("test"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
