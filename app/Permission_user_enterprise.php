<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_user_enterprise extends Model
{
    protected $table = 'permission_enterprise';

    protected $primaryKey = 'idpermission_enterprise';

	protected $fillable = [
		'idpermission_enterprise', 'user_has_module_iduser_has_module', 'enterprise_id',
	];
	public $timestamps = false;
}
