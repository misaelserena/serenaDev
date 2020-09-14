<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
	protected $table = 'enterprise';

	protected $fillable = [
		'name', 'rfc', 'details', 'address', 'number', 'colony', 'postalCode', 'city', 'phone', 'state_idstate', 'path', 'taxRegime', 'status', 'noCertificado', 'folioBill',
	];

	public function setPathAttribute($path)
	{
		if(is_string($path) || $path == null)
		{
			$this->attributes['path'] = $path;
		}
		else
		{
			$this->attributes['path'] = 'AdG'.time().'_enterprise.'.$path->getClientOriginalExtension();
			$name = '/images/enterprise/AdG'.time().'_enterprise.'.$path->getClientOriginalExtension();
			\Storage::disk('public')->put($name,\File::get($path));
		}
	}

	public function user()
	{
		return $this->belongsToMany('App\User','user_has_enterprise');
	}

	public function state()
	{
		return $this->belongsTo('App\State','state_idstate','idstate');
	}

	public function employerRegister()
	{
		return $this->hasMany('App\EmployerRegister');
	}

	public function scopeOrderName($query)
	{
			return $query->orderBy('name','asc');
	}

}
