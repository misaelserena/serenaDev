<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_has_module extends Model
{
    protected $table = 'user_has_module';

    protected $primaryKey = 'iduser_has_module';

	protected $fillable = [
		'user_id', 'module_id',
	];
	public $timestamps = false;

	public function department()
	{
		return $this->hasMany('App\PermissionDep','user_has_module_iduser_has_module','iduser_has_module');
	}

	public function enterprise()
	{
		return $this->hasMany('App\PermissionEnt','user_has_module_iduser_has_module','iduser_has_module');
	}
}
