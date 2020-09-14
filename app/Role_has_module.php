<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_has_module extends Model
{
    protected $table = 'role_has_module';

    protected $primaryKey = 'idrole_has_module';

	protected $fillable = [
		'idrole_has_module', 'role_id', 'module_id',
	];
	public $timestamps = false;
}
