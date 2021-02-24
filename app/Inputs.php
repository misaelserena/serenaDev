<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inputs extends Model
{
    protected $table = 'inputs';

    protected $whareHouseTypes = [
        1 => 'Papelería',
        2 => 'Herramienta',
    ];

    protected $fillable = [
        'quantity',
        'product_id',
        'quantity_ex',
        'price',
        'wholesale_price',
        'date',
        'users_id',
        'status',
        'description',
        'unit'
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->hasOne('App\Products','id','product_id');
    }

    public function measurementD()
    {
        return $this->hasOne('App\CatMeasurementTypes','id','measurement');
    }
    public function cat_c()
    {
        return $this->hasOne('App\CatWarehouseConcept','id','concept');
    }
    public function location()
    {
        return $this->hasOne('App\Place','id','place_location');
    }

    public function scopeOrderName($query)
	{
		return $query->orderBy('concept','asc');
    }

    public function versions()
    {
        return $this->hasMany('App\VersionWarehouse','idWarehouse','id');
    }

}
