<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\Cart;
use App\Country;
use App\State;
use App\City;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function checkout(){
        $cookie = Cookie::get('cookie_id');
        $carts = Cart::where('cookie_id', $cookie)->get();
        $countries = Country::orderBy('name', 'asc')->get();
        return view('frontend.checkout',[
            'carts' => $carts,
            'countries' => $countries
        ]);
    }

    function GetState($id){
        $states = State::where('country_id', $id)->get();

        return response()->json($states);
    }

    function GetCity($city_id){
        $cities = City::where('state_id', $city_id)->get();

        return response()->json($cities);
    }

}
