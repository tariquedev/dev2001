<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Gallery;
use App\Category;
use App\Blog;
use App\Attributes;
use Cookie;
use Str;
use App\Cart;
use App\Comment;
use App\Review;


class FrontendController extends Controller
{
    function front(){
        
        return view('frontend.main', [
            'products' => Product::limit(8)->get(),
        ]);
    }

    function SingleProduct($slug){
        
         
        $product = Product::where('slug', $slug)->first();
        $gallery = Gallery::where('product_id',  $product->id)->get();
        $Attributes = Attributes::where('product_id',  $product->id)->get();
        $collection = collect($Attributes);
        $groupBy = $collection->groupBy('color_id');
        
        return view('frontend.single_product', [
            'product' => $product,
            'gallery' => $gallery,
            'groupBy' => $groupBy,
            'reviews' => Review::where('product_id',$product->id )->get(),
        ]);
        // return abort(404);
    }

    function GetSize($color, $product){
        $output = '';
        $sizes = Attributes::where('color_id', $color)->where('product_id', $product)->get();
            foreach($sizes as $size){
                $output = $output.' <input name="size_id" type="radio" value="'.$size->size_id.'"> ' .$size->size->size_name.'';
            }
        echo $output;
    }

    function shop(){


        return view('frontend.shop',[
            'cats' => Category::orderBy('category_name', 'asc')->get(),
            'products' => Product::all()
        ]);
    }

    function blogs(){

        return view('frontend.blogs',[
            'blogs' => Blog::latest()->paginate(2)
        ]);
    }

    function SingleBlog($slug){
        $category = Category::orderBy('category_name', 'asc')->get();
        $blog = Blog::whereSlug($slug)->first();
        return view('frontend.blog_details', [
            'blog' => $blog,
            'category' => $category,
            'related' => Blog::where('category_id',$blog->category_id )->get()->except(['id', $blog->id]),
            'comments' => Comment::where('status', 2)->where('blog_id',  $blog->id)->latest()->get()
        ]);
    }

    function Qupdate(Request $request){
        $id = $request->id;
        $q = $request->qty_quantity;
        
        $cart = Cart::findOrFail($id);
        $cart->quantity = $q;
        $cart->save();

        return response()->json('OK');
    }

    function search(Request $request){

        $product = Product::query();

        if ($request->q)
        {
            // simple where here or another scope, whatever you like
            $product->where('title','like',$request->q);
        }

        if ($request->q)
        {
            
            $product->orwhere('price','like',$request->q);
        }

        if ($request->q)
        {
            $product->orwhere('slug', 'like',$request->q);
        }

        $all_product = $product->get();

    }
    
    
}


