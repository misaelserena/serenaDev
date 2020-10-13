<?php

use Illuminate\Database\Seeder;

class PermissionHasModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_has_module')->insert(
		 	[
				'users_id'		=> 1,
				'modules_id'	=> 1
			]);
		DB::table('permission_has_module')->insert(
			[
				'users_id'		=> 1,
				'modules_id'	=> 2
			]);
		DB::table('permission_has_module')->insert(
			[
				'users_id'		=> 1,
				'modules_id'	=> 3
			]);
		DB::table('permission_has_module')->insert(
			[
				'users_id'		=> 1,
				'modules_id'	=> 4
			]);
		DB::table('permission_has_module')->insert(
			[
				'users_id'		=> 1,
				'modules_id'	=> 5
			]);
    }
}
