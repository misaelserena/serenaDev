<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    protected $table = 'sales_detail';

    protected $fillable = [
    	'products_id',
    	'price',
    	'type_price',
    	'discount',
    	'subtotal',
    	'iva',
    	'total',
    	'sales_id'
    ];

    public function productData()
    {
        return $this->hasOne('App\Products','id','products_id');
    }
}
