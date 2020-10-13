<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
			'name'		=> 'Misael Serena',
			'email'		=> 'misael_serena@serenadev.com',
			'password'	=> bcrypt('serenamisael1'),
        ]);
    }
}
