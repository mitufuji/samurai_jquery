<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Image;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();
                  
        return view('posts.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'content' => 'required',
            'image' => 'nullable',
        ]);
   
        $dir = 'images';
        $file_name = $request->file('image');//->getClientOriginalName();
        //$request->file('image')->storeAs('public/' . $dir, $file_name);
        //$image_path = 'storage/' . $dir . '/' . $file_name;
        //$image_sample = base64_decode($request->file('image'));
        Storage::putFileAs("public/{$dir}", $request->file('image'), $file_name);

        $image = new Image();
        $image->name = $file_name;
        $image->path = "storage/{$dir}{$file_name}";
        $image->save();
        
        $post_image = Image::where('name', $file_name)->first();
        
        $post = new Post();
        $post->content = $request->input('content');
        $post->user_id = Auth::id();        
        $post->category_id = $request->input('category_id');        
        $post->user_name = Auth::user()->name;
        $post->image_id = $post_image->id;
        $post->image_name = $post_image->name;
        $post->image_path = $image->path;
        $post->save();
        
        $return_id = $post->category_id;
        $category = Category::find($return_id);
      
        return redirect()->route('posts.show', ['category' => $category]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $posts = Post::where('category_id', $category->id)->withCount('likes')->get();
        $categories = Category::all();
        //$image = Storage::get('storage/app/public/sample/de-an-sun-4xk-NZKehkY-unsplash (2).jpg');

        return view('posts.show', compact('category', 'posts', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        logger(111111);
        logger($post->image_path);
        //Storage::disk("public")->delete($post->image_path);
        Storage::delete($post->image_path);
        $post->image_id = null;
        $post->image_name = null;
        $post->image_path = null;
        $post->save();

        $return_id = $post->category_id;
        $category = Category::find($return_id);

        return redirect()->route('posts.show', ['category' => $category]);
    }

}
