<?php

namespace App\Http\Controllers;

use App\Attributes;
use App\Brand;
use App\Category;
use App\Color;
use App\Gallery;
use App\Product;
use App\Size;
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    function products(){

        return view('backend.product.product-list', [
            'products' => Product::paginate(),
            'product_count' => Product::count()
        ]);
    }

    function ProductAdd(){


        return view('backend.product.product-form', [
            'scat' => SubCategory::orderBy('subcategory_name', 'asc')->get(),
            'categories' => Category::orderBy('category_name', 'asc')->get(),
            'brands' => Brand::orderBy('brand_name', 'asc')->get(),
            'colors' => Color::orderBy('color_name', 'asc')->get(),
            'sizes' => Size::orderBy('size_name', 'asc')->get(),
        ]);
    }

    function ProductStore(Request $request){

        if($request->hasFile('thumbnail')){
            $image  = $request->file('thumbnail');
            $ext = Str::random(10).'.'. $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('images/'. $ext));

            $product_id = Product::insertGetId([
                'title' => $request->title,
                'price' => $request->price,
                'summary' => $request->summary,
                'description' => $request->description,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'thumbnail' => $ext,
                'created_at' => Carbon::now()
            ]);
                
                foreach ($request->color_id as $key => $value) {
                   Attributes::insert([
                        'color_id' => json_encode($request->color_id),
                       'product_id' => $product_id,
                       'size_id' => $request->size_id[$key],
                       'quantity' => $request->quantity[$key],
                       'created_at' => Carbon::now()
                   ]);
                }

            if($request->hasFile('images')){
                $images  = $request->file('images');

                $new_location = public_path('gallery/')
                . Carbon::now()->format('Y/m/')
                . $product_id .'/';

                File::makeDirectory($new_location, $mode = 0777, true, true);

                foreach($images as $img){
                    $img_ext = Str::random(10) . '.' . $img->getClientOriginalExtension();
                    Image::make($img)->save($new_location . $img_ext);

                    Gallery::insert([
                        'product_id' => $product_id,
                        'images' => $img_ext,
                        'created_at' => Carbon::now()
                    ]);
                }

            }

            return "OK";


            // return back();

        }
    }

    function ProductEdit($slug){

        return view('backend.product.product-edit', [
            'brands' => Brand::all(),
            'categories' => Category::all(),
            
            'product' => Product::where('slug', $slug)->first()
        ]);
    }

    function ProductUpdate(Request $request){
        // $request->validate([
        //     'thumbnail' => ['required', 'image']
        // ]);
    $product = Product::findOrFail($request->product_id);
        if($request->hasFile('thumbnail')){
            $image  = $request->file('thumbnail');
            $ext = Str::random(10).'.'. $image->getClientOriginalExtension();

            $old_img_location = public_path('images/'.$product->thumbnail);
            if(file_exists($old_img_location)){
                unlink($old_img_location);
            }

            Image::make($image)->save(public_path('images/'. $ext));

            $product->thumbnail = $ext;
            
        }

            $product->title = $request->title;
            $product->price = $request->price;
            $product->slug = Str::slug($request->title);
            $product->summary = $request->summary;
            $product->description = $request->description;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->save();
            return 'ProductUpdate';
        
        if($request->hasFile('thumbnail')){
            $image  = $request->file('thumbnail');

            foreach($image as $habla){
                $ext = Str::random(10).'.'. $habla->getClientOriginalExtension();
                Image::make($habla)->save(public_path('images/'. $ext));
            }

        }
    }

    function CategoryAjax($id){
       $scat = SubCategory::where('category_id', $id)->get();
       return response()->json($scat);
    }

    function ProductImageEdit($slug){
        $product_id = Product::where('slug', $slug)->first();
        $gallery = Gallery::where('product_id', $product_id->id)->get();

        return view('backend.product.product_image_edit', [
            'gallery' =>  $gallery,
            'product_id' => $product_id->id
        ]);
    }

    function GalleryImageDelete($id){
            $Gallery = Gallery::findOrFail($id);
            $old_img = public_path('gallery/'.$Gallery->created_at->format('Y/m/').$Gallery->product_id .'/'. $Gallery->images);
            if (file_exists($old_img)) {
                unlink($old_img);
                $Gallery->delete();
                return back();
            }
            
    }

    function MultiImgUpdate(Request $request){

        if($request->hasFile('images')){

            $product_id = $request->product_id;
                $images  = $request->file('images');

                $new_location = public_path('gallery/')
                . Carbon::now()->format('Y/m/')
                . $product_id .'/';

                File::makeDirectory($new_location, $mode = 0777, true, true);

                foreach($images as $img){
                    $img_ext = Str::random(10) . '.' . $img->getClientOriginalExtension();
                    Image::make($img)->resize(500, 500)->save($new_location . $img_ext);

                    // Gallery::insert([
                    //     'product_id' => $product_id,
                    //     'images' => $img_ext,
                    //     'created_at' => Carbon::now()
                    // ]);

                    $rakib = new Gallery;
                    $rakib->product_id = $product_id;
                    $rakib->images = $img_ext;
                    $rakib->save();
                }

                return back();

            }
    }

    function ProductDelete($id){
        $product = Product::findOrFail($id);
        $old_img = public_path('images/'. $product->thumbnail);
            if (file_exists($old_img)) {

                // return "Thumbnail Ache";
                unlink($old_img);
                
            }
        $gallery = Gallery::where('product_id', $product->id)->get();
            foreach($gallery as $item){
                $oldimg = public_path('gallery/'.$item->created_at->format('Y/m/').$item->product_id .'/'. $item->images);
                if (file_exists($oldimg)) {
                    // return "Ache Image";
                    unlink($oldimg);
                    $item->delete();
                }
            }
        $product->delete();
        return "Deleted Successfully";
    }
    
}