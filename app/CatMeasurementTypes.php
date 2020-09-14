<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatMeasurementTypes extends Model
{
	protected $table  	= 'catMeasurementTypes';

	protected $fillable = [
		'description','type','equivalence','father','child_order'
	];

	public $timestamps = false;

	public function childrens() {
    return $this->hasMany('App\CatMeasurementTypes','father');
	}
	public function parent() {
			return $this->belongsTo('App\CatMeasurementTypes','father','id');
	}
	
}
