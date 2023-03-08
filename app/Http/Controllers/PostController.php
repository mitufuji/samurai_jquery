<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        ]);
        
        $post = new Post();
        $post->content = $request->input('content');
        $post->user_id = Auth::id();        
        $post->category_id = $request->input('category_id');        
        $post->user_name = Auth::user()->name;
        $post->save();

        $return_id = $post->category_id;
        $category = Category::find($return_id);
        // $category_choice = Category::where('id', $post->category_id)->get();
        // logger($category_choice);
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
        $posts = Post::where('category_id', $category->id)->get();
        $categories = Category::all();

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
        //
    }

    public function like(Request $request)
    {
        $user_id = Auth::user()->id; 
        $post_id = $request->post_id; 
        $already_liked = Like::where('user_id', $user_id)->where('post_id', $post_id)->first();

        if (!$already_liked) { 
            $like = new Like; 
            $like->post_id = $post_id; 
            $like->user_id = $user_id;
            $like->save();
        } else { 
            Like::where('post_id', $post_id)->where('user_id', $user_id)->delete();
        }
        
        $post_likes_count = Post::withCount('likes')->findOrFail($post_id)->likes_count;
        $param = [
            'post_likes_count' => $post_likes_count,
        ];
        return response()->json($param); 
    }
}
