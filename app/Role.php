<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'role';

	protected $fillable = [
		'id', 'name', 'details', 'status',
	];

	/* RELACION CON EL MODELO User */
	public function user()
	{
		return $this->hasOne('App\User','role_id','id');
	}

	/* RELACION CON EL MODELO Module */
	public function module()
	{
		return $this->belongsToMany('App\Module', 'role_has_module','role_id','module_id');
	}

}
