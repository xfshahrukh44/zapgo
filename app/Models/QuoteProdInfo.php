<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuoteProdInfo extends Model
{
    protected $table = "quote_prod_info";

    protected $appends = ['product_title', 'product_price'];

    public function getProductTitleAttribute(){
        $data = DB::table('products')->where('id', $this->product)->first();      
        return $data->product_title;
    }

    public function getProductPriceAttribute(){
        $data = DB::table('products')->where('id', $this->product)->first();      
        return $data->price;
    }
}
