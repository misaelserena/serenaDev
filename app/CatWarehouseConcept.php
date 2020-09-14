<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatWarehouseConcept extends Model
{
	protected $table  	= 'catWarehouseConcept';

	protected $fillable = [
		'description','warehouseType'
	];

	public $timestamps = false;

}
