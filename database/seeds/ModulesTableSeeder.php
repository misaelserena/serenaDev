<?php

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('modules')->insert(
	 	[
			'name'				=> 'Ordenes',
			'father'			=> null,
			'accion'			=> null,
			'details'			=> 'Sirve para dar de alta ordenes y consultar',
			'url'				=> '/orders',
			'permissionRequire'	=> 1,
			'order'				=> 0,
		]);
		DB::table('modules')->insert([
			'name'				=> 'Paquetes',
			'father'			=> null,
			'accion'			=> null,
			'details'			=> 'Sirve para dar de alta paquetes y consultar',
			'url'				=> '/packs',
			'permissionRequire'	=> 1,
			'order'				=> 0,
		]);
		DB::table('modules')->insert([
			'name'				=> 'Clientes',
			'father'			=> null,
			'accion'			=> null,
			'details'			=> 'Sirve para dar de alta clientes y consultar',
			'url'				=> '/client',
			'permissionRequire'	=> 1,
			'order'				=> 0,
		]);
		DB::table('modules')->insert([
			'name'				=> 'Reportes',
			'father'			=> null,
			'accion'			=> null,
			'details'			=> 'Sirve para dar de alta reportes y consultar',
			'url'				=> '/reports',
			'permissionRequire'	=> 1,
			'order'				=> 0,
		]);
		DB::table('modules')->insert([
			'name'				=> 'Contactos',
			'father'			=> null,
			'accion'			=> null,
			'details'			=> 'Sirve para dar de alta contactos y consultar',
			'url'				=> '/contacts',
			'permissionRequire'	=> 1,
			'order'				=> 0,
		]);
	}
}
