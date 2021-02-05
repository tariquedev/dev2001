<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    function gallery(){

        return $this->hasMany(Gallery::class, 'product_id');
    }

    function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    function subcategory(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    function attribute(){

        return $this->hasMany(Attributes::class, 'product_id');
    }

    function cart(){

        return $this->hasMany(Cart::class, 'product_id');
    }
}
