<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
	protected $table  	= 'provider';

	protected $primaryKey = 'id';

	protected $fillable = [
		'id', 'businessName', 'phone', 'rfc', 'status', 'users_id', 'address', 'number', 'colony', 'postalCode', 'city', 'state_idstate',
	];

	public $timestamps = false;

}
