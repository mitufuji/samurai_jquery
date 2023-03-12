<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
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
            Like::where('post_id', $post_id)
                ->where('user_id', $user_id)
                ->delete();
        }
        
        $post_likes_count = Post::withCount('likes')
            ->findOrFail($post_id)
            ->likes_count;
        $param = [
            'post_likes_count' => $post_likes_count,
        ];

        return response()->json($param); 
    }
}
