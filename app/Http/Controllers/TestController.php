<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    function about(){
        $about = "This is my about page";
        return view('pages.about', compact('about'));
    }
}
