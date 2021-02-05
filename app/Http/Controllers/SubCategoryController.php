<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    function SubCategoryView(){

        $scategories = SubCategory::with('category')->paginate();

        return view('backend.subcategory.subcategory_view',[
            'scategories' => $scategories
        ]);
    }

    function SubCategoryForm(){

        return view('backend.subcategory.subcategory_add',[
            'categories' => Category::orderBy('category_name', 'asc')->get()
        ]);
    }

    function SubCategoryPost(Request $request){

        SubCategory::insert([
            'subcategory_name' => $request->subcategory_name,
            'slug' => Str::slug($request->subcategory_name),
            'category_id' => $request->category_id,
            'created_at' => Carbon::now()
        ]);
        return redirect('subcategory-view');
    }

    function SubCategoryEdit($scat_id){
        $scat = SubCategory::where('slug', $scat_id )->first();

        return view('backend.subcategory.subcategory_edit', [
            'scat' => $scat,
            'categories' => Category::orderBy('category_name', 'asc')->get()
        ]);
    }
}
