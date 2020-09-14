<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatWarehouseType extends Model
{
	protected $table  	= 'catWarehouseType';

	protected $fillable = [
		'description'
	];

	public $timestamps = false;

}
