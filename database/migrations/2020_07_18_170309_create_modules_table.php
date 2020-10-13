<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modules', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name',100);
			$table->integer('father')->nullable(true);
			$table->string('cathegory',200)->nullable(true);
			$table->integer('accion')->nullable(true);
			$table->string('details',500)->nullable(true);
			$table->string('url',500)->nullable(true);
			$table->integer('permissionRequire')->default('1');
			$table->integer('order')->nullable(true);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('modules');
	}
}
