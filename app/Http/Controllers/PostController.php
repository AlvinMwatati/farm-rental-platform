<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use App\Models\Like;
use App\Models\SharedPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Create a new post
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10240',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;

        // Handle image upload
        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts/images', 'public');
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            $post->video = $request->file('video')->store('posts/videos', 'public');
        }

        $post->save();

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    // Delete a post
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this post.');
        }

        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully!');
    }

    // Fetch posts and users for the forum
    public function index()
    {
        $posts = Post::with(['user', 'replies.user', 'likes'])->latest()->get();
        $users = User::all(); // For the share dropdown
        return view('forum', compact('posts', 'users'));
    }

    // Fetch all users (for sharing feature)
    public function listUsers()
    {
        $users = User::select('id', 'name')->get();
        return response()->json(['users' => $users]);
    }

    // Share post with another user
    public function sharePost(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'recipient_id' => 'required|exists:users,id',
        ]);

        $post = Post::find($request->post_id);
        $recipient = User::find($request->recipient_id);

        // Example: Notify recipient (Optional: Save in DB or notify via email)
        // $recipient->notifications()->create(['message' => 'A post was shared with you']);

        return response()->json(['success' => true, 'message' => 'Post shared successfully!']);
    }
}
