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
        'shipping_status',
    	'users_id'
    ];

    public function detail()
    {
        return $this->hasMany('App\SalesDetail');
    }

    public function clientData()
    {
    	return $this->hasOne('App\Client','id','client_id');
    }

    public function coffeeOneKg()
    {
        return $this->hasMany('App\SalesDetail')->where('products_id',1)->count();
    }

    public function status()
    {
        return $this->shipping_status == 1 ? 'Entregado' : 'Pendiente';
    }
}
