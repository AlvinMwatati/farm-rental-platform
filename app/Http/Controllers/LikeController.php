<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // Like a post
    public function store(Post $post)
    {
        $like = Like::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        return redirect()->back()->with('success', 'Post liked!');
    }

    // Unlike a post
    public function destroy(Post $post)
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $post->id)->first();
        if ($like) {
            $like->delete();
        }

        return redirect()->back()->with('success', 'Post unliked!');
    }
}