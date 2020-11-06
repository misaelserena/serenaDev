<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';

    protected $fillable = [
    	'client_id',
    	'discount',
    	'subtotal',
    	'iva',
    	'total',
    	'users_id'
    ];

    public function clientData()
    {
    	return $this->hasOne('App\Client','id','client_id');
    }

}
