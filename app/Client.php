<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table  	= 'client';

	protected $primaryKey = 'id';

	protected $fillable = [
		'id', 'name', 'last_name', 'scnd_last_name', 'phone', 'rfc', 'status', 'users_id', 'address', 'number', 'colony', 'postalCode', 'city', 'state_idstate',
	];

	public $timestamps = false;

	public function states()
	{
		return $this->hasOne('App\State','idstate','state_idstate');
	}

	public function scopeOrderName($query)
	{
			return $query->orderBy('name','asc')->orderBy('last_name','asc')->orderBy('scnd_last_name','asc');
	}

	public function fullName()
	{
		return $this->name.' '.$this->last_name.' '.$this->scnd_last_name;
	}
}
