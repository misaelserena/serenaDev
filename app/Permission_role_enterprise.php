<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_role_enterprise extends Model
{
    protected $table = 'permission_role_enterprise';

    protected $primaryKey = 'idpermission_role_ent';

	protected $fillable = [
		'idpermission_role_ent', 'role_has_module_idrole_has_module', 'enterprise_id',
	];
	public $timestamps = false;
}
