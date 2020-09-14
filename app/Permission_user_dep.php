<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_user_dep extends Model
{
    protected $table = 'permission_department';

    protected $primaryKey = 'idpermission_department';

	protected $fillable = [
		'idpermission_department', 'user_has_module_iduser_has_module', 'departament_id',
	];
	public $timestamps = false;
}
