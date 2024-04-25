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
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'company', 'address', 'city', 'state', 'product', 'quantity', 'message', 'start_date', 'end_date', 'number_of_days'];

    public function productss()
    {
        return $this->belongsTo('App\Product', 'product', 'id');
    }

}
