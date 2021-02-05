<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'quantity',
    ];
    function product(){

        return $this->belongsTo(Product::class, 'product_id');
    }
}
