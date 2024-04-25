<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulkorder extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bulkorders';

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
    protected $fillable = ['customer_name', 'customer_email', 'customer_phone', 'product_name', 'quantity', 'amount', 'transaction_id', 'status'];


}
