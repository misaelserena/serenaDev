<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
	protected $table = 'department';

	protected $fillable = [
		'id', 'name', 'details', 'status',
	];

	/* RELACION CON EL MODELO User */
	public function user()
	{
		return $this->hasOne('App\User','departament_id','id');
	}

	public function inCharge()
	{
		return $this->belongsToMany('App\User','user_has_department');
	}
	public function scopeOrderName($query)
	{
			return $query->orderBy('name','asc');
	}
}
