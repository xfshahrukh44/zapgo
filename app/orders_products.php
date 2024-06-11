<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders_products extends Model
{
	protected $table = 'orders_products';
	public $primaryKey = 'orders_products_id';

	// public function order() {
    //     return $this->belongsTo(Order::class, 'orders_id', 'id');
    // }

    // public function product() {
    //     return $this->belongsTo(Product::class, 'order_products_product_id', 'id');
    // }
   
} 