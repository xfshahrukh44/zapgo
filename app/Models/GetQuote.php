<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GetQuote extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'get_quotes';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','first_name', 'last_name', 'email', 'phone', 'company', 'address', 'city', 'state', 'product', 'quantity', 'message', 'start_date', 'end_date', 'number_of_days', 'bulk_amount', 'bulk_status', 'total_amount'];

    protected $appends = ['product_total_amount'];

    public function productss()
    {
        return $this->belongsTo('App\Product', 'product', 'id');
    }

    public function quote_products()
    {
        return $this->hasMany(QuoteProdInfo::class, 'qoute_id', 'id');
    }

    public function getProductTotalAmountAttribute()
    {
        $data = QuoteProdInfo::where('qoute_id', $this->id)->get();
        $total = 0;
        foreach ($data as $key => $value) {
            $total += $value->price;
        }
        return $total;

    }

}
