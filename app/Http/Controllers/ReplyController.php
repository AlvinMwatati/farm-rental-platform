<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use App\Models\SharedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    // Create a new reply
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $reply = new Reply();
        $reply->user_id = Auth::id();
        $reply->post_id = $post->id;
        $reply->content = $request->content;
        $reply->save();

        return redirect()->back()->with('success', 'Reply posted successfully!');
    }

    // Delete a reply
    public function destroy(Reply $reply)
    {
        if ($reply->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this reply.');
        }

        $reply->delete();
        return redirect()->back()->with('success', 'Reply deleted successfully!');
    }
}