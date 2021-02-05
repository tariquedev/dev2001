<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
