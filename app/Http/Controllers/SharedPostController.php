<?php

namespace App\Http\Controllers;

use App\Models\SharedPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SharedPostController extends Controller
{
    // Share a post with another user
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
        ]);

        SharedPost::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'recipient_id' => $request->recipient_id,
        ]);

        return redirect()->back()->with('success', 'Post shared successfully!');
    }
}