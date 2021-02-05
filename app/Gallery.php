<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    function product(){

        return $this->belongsTo(Product::class, 'product_id');
    }
}
