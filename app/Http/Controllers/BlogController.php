<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use App\Category;
use Str;
use Auth;
use Image;
use File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::paginate();
        return view('backend.blog.blog', [
            'blog' => $blog,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.blog.blog-form', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'thumbnail' => ['required', 'image']
        ]);

        $blog = new Blog;

        $blog->title = $request->title;
        $blog->summary = $request->summary;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category_id;
        $blog->user_id = Auth::id();
        $blog->save();

        if($request->hasFile('thumbnail')){

            $new_location = public_path('images/thumbnail/')
            . $blog->created_at->format('Y/m/')
            . $blog->id .'/';

            File::makeDirectory($new_location, $mode = 0777, true, true);
            $image  = $request->file('thumbnail');
            $ext = Str::slug($request->title).'.'. $image->getClientOriginalExtension();
            // $ext->move(public_path('images/thumbnail/'. $ext));
            Image::make($image)->save($new_location . $ext);
            $b_update = Blog::findOrFail($blog->id);
            $b_update->thumbnail = $ext;
            $b_update->save();

        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return $blog;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
