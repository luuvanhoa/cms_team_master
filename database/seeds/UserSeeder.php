<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
    	DB::table('users')->delete();
        DB::table('users')->insert([
        	'id'=> 1,
			'name' => 'admin',
			'password' => Hash::make('admin'),
			'username' => 'admin',
			'email' => 'admin@gmail.com',
            'admin' => 1,
            'group_id' => 1,
            'address' => '',
            'phone' => '',
            'birthday' => Carbon::now(),
            'confirmation_code' => ''
		]);
    }
}
