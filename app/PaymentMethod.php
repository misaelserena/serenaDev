<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'paymentMethod';

	protected $primaryKey = 'idpaymentMethod';

	protected $fillable = ['idpaymentMethod','method'];

	public $timestamps = false;

	public function resource()
	{
		return $this->belongsTo('App\Resource','idpaymentMethod','idpaymentMethod');
	}

	public function expense()
	{
		return $this->belongsTo('App\Expenses','idpaymentMethod','idpaymentMethod');
	}
	public function scopeOrderName($query)
	{
		return $query->orderBy('method','asc');
  }
}
