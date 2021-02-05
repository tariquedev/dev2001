<?php

namespace App\Http\Controllers;

// use App\Category;
use Carbon\Carbon;
use App\Category;
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('verified');
    }
    function CategoryList(){
        $categories = Category::paginate();
        $trash_catgory = Category::onlyTrashed()->paginate(2);
        return view('backend.category.category-list', [
            'categories' => $categories,
            'trash_catgory' => $trash_catgory
        ]);
    }

    function CategoryPost(Request $req){

        $req->validate([
            'category_name' => ['required', 'min:3','unique:categories', "regex:/^[A-Za-z0-9 \-]*$/"]

        ],[
            'category_name.required' => 'Vatija! Apnar name dewa lagbe',
            'category_name.min' => 'Ki bepar! Apni ki kana naki? Minimum 3 characters dewa lagbe'
        ]
    );

        $data = new Category;
        $data->slug = Str::slug($req->category_name);
        $data->category_name = $req->category_name;
        $data->save();

        // Category::insert([
        //     // db column field  => Form Request Value
        //     'category_name' => $req->category_name,
        //     'created_at' => Carbon::now()
        // ]);
        return back()->with('CategoryAdd', 'Category Added Successfully');
    }

    // function CategoryDelete($cat_id){
    //     Category::findOrFail($cat_id)->delete();
    //     return back();
    // }

    function CategoryDelete($id){

        $cat_product = Product::where('category_id', $id)->count();

        if($cat_product > 0){
            return back()->with('Vatija', "You can't delete this category");
        }
        else{
            Category::findOrFail($id)->delete();
            return back()->with('Vatija2', "Category Deleted Successfully");;
        }
        
    }

    function CategoryRestore($id){
            Category::withTrashed()->findOrFail($id)->restore();
        return back();
    }

    function CategoryPermanentDelete($id){
        Category::withTrashed()->findOrFail($id)->forceDelete();
        return back()->with('ParmanentDelete', 'Category Parmanent Deleted Successfully');;
    }

    function CategoryEdit($id){

        $categories = Category::paginate(3);
        $trash_catgory = Category::onlyTrashed()->paginate(2);
        $edit_category = Category::findOrFail($id);

        return view('backend.category.category-edit', [
            'categories' => $categories,
            'trash_catgory' => $trash_catgory,
            'edit_category' => $edit_category
        ]);
    }

    function CategoryUpdate(Request $req){

        // return $req->all();
        // Category::findOrFail($req->id)->update([
        //     'category_name' => $req->category_name,
        //     'slug' => Str::slug($req->category_name),
        //     'updated_at' => Carbon::now()
        // ]);

        $update = Category::findOrFail($req->id);
        $update->category_name = $req->category_name;
        $update->slug = Str::slug($req->category_name);
        $update->save();

        return back();
    }

    function SelectedCategoryDelete(Request $request){

        if ($request->cat_id != '') {
            foreach($request->cat_id as $cat){
                Category::findOrFail($cat)->delete();
            }
        
            return back();
        }
        
    }
}
