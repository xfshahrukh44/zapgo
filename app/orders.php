<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
	protected $table = 'orders';
	public $primaryKey = 'orders_id';

	// public function orderProducts() {
    //     return $this->hasMany(orders_products::class, 'orders_id');
    // }
   
} 