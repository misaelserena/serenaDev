<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';

	protected $primaryKey = 'idstate';

	protected $fillable = ['idstate','description','c_state'];

	public $timestamps = false;

	public function state()
	{
		return $this->hasOne('App\Enterprise','state_idstate','idstate');
	}

	public function scopeOrderName($query)
	{
		return $query->orderBy('description','asc');
	}
}
