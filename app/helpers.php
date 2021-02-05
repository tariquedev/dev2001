<?php

use App\Cart;


function cart(){
    $cookie = Cookie::get('cookie_id');

    return Cart::where('cookie_id', $cookie)->get();
}

?>