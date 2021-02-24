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
			'name'				=> 'Ventas', 
			'father'			=> NULL, 
			'cathegory'			=> NULL,
			'accion'			=> NULL,
			'details'			=> 'Sirve para dar de alta ordenes y consultar', 
			'url'				=> '/sales',
			'permissionRequire'	=> 1,
			'order'				=> 0, 
			'icon'				=> 'archive-fill',
		]);
		DB::table('modules')->insert(
	 	[
			'name'				=> 'Paquetes', 
			'father'			=> NULL, 
			'cathegory'			=> NULL,
			'accion'			=> NULL,
			'details'			=> 'Sirve para dar de alta paquetes y consultar', 
			'url'				=> '/packs',
			'permissionRequire'	=> 1,
			'order'				=> 0, 
			'icon'				=> 'box',
		]);
		DB::table('modules')->insert(
	 	[
			'name'				=> 'Administración', 
			'father'			=> NULL, 
			'cathegory'			=> NULL,
			'accion'			=> NULL,
			'details'			=> 'Sirve para dar de alta clientes y consultar', 
			'url'				=> '/administration',
			'permissionRequire'	=> 1,
			'order'				=> 0, 
			'icon'				=> 'clipboard-data',
		]);
		DB::table('modules')->insert(
	 	[
			'name'				=> 'Reportes', 
			'father'			=> NULL, 
			'cathegory'			=> NULL,
			'accion'			=> NULL,
			'details'			=> 'Sirve para dar de alta reportes y consultar', 
			'url'				=> '/reports',
			'permissionRequire'	=> 1,
			'order'				=> 0, 
			'icon'				=> 'bar-chart-line-fill',
		]);
		DB::table('modules')->insert(
	 	[
			'name'				=> 'Contactos', 
			'father'			=> NULL, 
			'cathegory'			=> NULL,
			'accion'			=> NULL,
			'details'			=> 'Sirve para dar de alta contactos y consultar', 
			'url'				=> '/contacts',
			'permissionRequire'	=> 1,
			'order'				=> 0, 
			'icon'				=> 'person-fill',
		]);
		DB::table('modules')->insert(
	 	[
			'name'				=> 'Configuración', 
			'father'			=> NULL, 
			'cathegory'			=> NULL,
			'accion'			=> NULL,
			'details'			=> 'Configuración del sistema', 
			'url'				=> '/configuration',
			'permissionRequire'	=> 0,
			'order'				=> 0, 
			'icon'				=> 'puzzle-fill',
		]);
		DB::table('modules')->insert(
	 	[
			'name'				=> 'Módulos', 
			'father'			=> 6, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'configuration/module', 
			'permissionRequire'	=> 0,
			'order'				=> 0, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Alta', 
			'father'			=> 7, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'configuration/module/create', 
			'permissionRequire'	=> 0,
			'order'				=> 1, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Edición', 
			'father'			=> 7, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'configuration/module/edit', 
			'permissionRequire'	=> 0,
			'order'				=> 2, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Usuarios', 
			'father'			=> 6, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'configuration/user', 
			'permissionRequire'	=> 0,
			'order'				=> 0, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Alta', 
			'father'			=> 10, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'configuration/user/create', 
			'permissionRequire'	=> 0,
			'order'				=> 1, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Edición', 
			'father'			=> 10, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'configuration/user/edit', 
			'permissionRequire'	=> 0,
			'order'				=> 2, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Clientes', 
			'father'			=> 3, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'administration/client', 
			'permissionRequire'	=> 1,
			'order'				=> 0, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Alta', 
			'father'			=> 13, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'administration/client/create', 
			'permissionRequire'	=> 1,
			'order'				=> 1, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Edición', 
			'father'			=> 13, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'administration/client/edit', 
			'permissionRequire'	=> 1, 
			'order'				=> 2, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Productos', 
			'father'			=> 1, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'sales/product', 
			'permissionRequire'	=> 1, 
			'order'				=> 0, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Alta', 
			'father'			=> 16, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'sales/product/create', 
			'permissionRequire'	=> 1, 
			'order'				=> 1, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Edición', 
			'father'			=> 16, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'sales/product/edit', 
			'permissionRequire'	=> 1, 
			'order'				=> 2, 
			'icon'				=> NULL, 
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Catálogo de Productos', 
			'father'			=> 6, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'configuration/product', 
			'permissionRequire'	=> 0, 
			'order'				=> 0, 
			'icon'				=> NULL, 
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Alta', 
			'father'			=> 19, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'configuration/product/create', 
			'permissionRequire'	=> 0, 
			'order'				=> 1, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Edición', 
			'father'			=> 19, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'configuration/product/edit', 
			'permissionRequire'	=> 0, 
			'order'				=> 2, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Entradas', 
			'father'			=> 3, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'administration/inputs', 
			'permissionRequire'	=> 1, 
			'order'				=> 0, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Alta', 
			'father'			=> 22, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'administration/inputs/create', 
			'permissionRequire'	=> 1, 
			'order'				=> 1, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Edición', 
			'father'			=> 22, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'administration/inputs/edit', 
			'permissionRequire'	=> 1, 
			'order'				=> 2, 
			'icon'				=> NULL, 
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Proveedores', 
			'father'			=> 3, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'administration/provider', 
			'permissionRequire'	=> 1, 
			'order'				=> 0, 
			'icon'				=> NULL,
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Alta', 
			'father'			=> 25, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'administration/provider/create', 
			'permissionRequire'	=> 1, 
			'order'				=> 1, 
			'icon'				=> NULL, 
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Edición', 
			'father'			=> 25, 
			'cathegory'			=> NULL, 
			'accion'			=> NULL, 
			'details'			=> NULL, 
			'url'				=> 'administration/provider/edit', 
			'permissionRequire'	=> 1, 
			'order'				=> 2, 
			'icon'				=> NULL, 
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Administrativos', 
			'father'			=> 4, 
			'cathegory'			=> 'Ventas', 
			'accion'			=> NULL, 
			'details'			=> 'reporte de ventas realizadas', 
			'url'				=> 'reports/administration', 
			'permissionRequire'	=> 1, 
			'order'				=> 1, 
			'icon'				=> NULL, 
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Ventas', 
			'father'			=> 28, 
			'cathegory'			=> 'Ventas', 
			'accion'			=> NULL, 
			'details'			=> 'Reportes de excel y gráficas de ventas', 
			'url'				=> 'reports/administration/sales', 
			'permissionRequire'	=> 1, 
			'order'				=> 1, 
			'icon'				=> NULL, 
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Proveedores', 
			'father'			=> 28, 
			'cathegory'			=> 'Administrativos', 
			'accion'			=> NULL, 
			'details'			=> 'Reporte de proveedores', 
			'url'				=> 'reports/administration/provider', 
			'permissionRequire'	=> 1, 
			'order'				=> 2, 
			'icon'				=> NULL, 
		]);
		DB::table('modules')->insert(
	 	[	
			'name'				=> 'Entradas vs Salidas', 
			'father'			=> 28, 
			'cathegory'			=> 'Entradas y salidas', 
			'accion'			=> NULL, 
			'details'			=> 'Comprobar utilidades', 
			'url'				=> 'reports/administration/inputs-outputs', 
			'permissionRequire'	=> 1, 
			'order'				=> 3, 
			'icon'				=> NULL,
		]);
	}
}
