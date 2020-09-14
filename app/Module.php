<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
	protected $table = 'module';

	protected $fillable = [
		'id', 'name', 'father', 'accion', 'details', 'icon', 'url', 'created_at', 'updated_at', 'permissionRequire'
	];

	public function role()
	{
		return $this->belongsToMany('App\Role','role_has_module','module_id','role_id');
	}

	public function user()
	{
		return $this->belongsToMany('App\User','user_has_module','module_id','user_id');
	}

	public function fatherModule()
	{
		return $this->belongsTo('App\Module','father','id');
	}
}
