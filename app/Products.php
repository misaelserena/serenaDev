<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
	protected $table  = 'products';

	protected $fillable = [
		'code',
		'description',
		'net_content',
		'unit',
		'price',
		'provider_id',
		'min_wholesale_quantity',
		'wholesale_price',
		'users_id',
		'status',
		'created_at',
		'updated_at',
	];

	public function provider()
	{
		return $this->hasOne('App\Provider','id','provider_id');
	}

	public function scopeOrderDescription($query)
	{
		return $query->orderBy('description','asc');
	}
}
