<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    protected $table = 'banks';

    protected $primaryKey = 'idBanks';

    protected $fillable = 
    [
    	'idBanks','description'
    ];
    public $timestamps = false;

    public function employees()
    {
    	return $this->hasMany('App\Employee','idBanks','idBanks');
    }
    public function scopeOrderName($query)
	{
		return $query->orderBy('description','asc');
	}
}