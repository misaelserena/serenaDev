<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouse';

    protected $whareHouseTypes = [
        1 => 'Papelería',
        2 => 'Herramienta',
    ];

    protected $fillable = [
        'idwarehouse',
        'quantity',
        'product_id',
        'quantity_ex',
        'price',
        'wholesale_price',
        'warehouseType',
        'users_id',
        'status'];

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

    public function wareHouse()
    {
        return $this->hasOne('App\CatWarehouseType','id','warehouseType');
    }

    public function versions()
    {
        return $this->hasMany('App\VersionWarehouse','idWarehouse','idwarehouse');
    }

}
