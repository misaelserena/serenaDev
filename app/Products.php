<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CatMeasurementTypes;

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

	public function quantitySold()
	{
		return $this->hasMany('App\SalesDetail','products_id','id')->sum('quantity');
	}

	public function nameProduct()
	{
		return $this->description.' '.$this->net_content.' '.CatMeasurementTypes::where('description',$this->unit)->first()->abbreviation;
	}
}
