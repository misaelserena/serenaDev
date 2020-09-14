<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
	protected $table = 'area';

	protected $fillable = [
		'id', 'name', 'details', 'status',
	];

	/* RELACION CON EL MODELO User */
	public function user()
	{
		return $this->hasOne('App\User','area_id','id');
	}
	
	public function scopeOrderName($query)
	{
			return $query->orderBy('name','asc');
	}

}
