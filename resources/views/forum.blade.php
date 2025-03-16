@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Forum</h1>

    <!-- Create Post Form -->
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="mb-6 bg-white p-6 rounded-lg shadow-md">
        @csrf
        <textarea name="content" rows="3" class="w-full p-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Share your idea..."></textarea>
        <div class="mt-2">
            <input type="file" name="image" class="mb-2">
            <input type="file" name="video" class="mb-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all">Post</button>
        </div>
    </form>

    <!-- Display Posts -->
    @foreach($posts as $post)
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="flex items-center mb-4">
                <span class="font-bold text-gray-800">{{ $post->user->name }}</span>
                <span class="text-sm text-gray-500 ml-2">{{ $post->created_at->diffForHumans() }}</span>
            </div>
            <p class="mb-4 text-gray-700">{{ $post->content }}</p>

            <!-- Post Media -->
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="mb-4 rounded-lg">
            @endif
            @if($post->video)
                <video controls class="mb-4 rounded-lg">
                    <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif

            <!-- Like and Share Buttons -->
            <div class="flex items-center space-x-4">
                <!-- Like Button -->
<form action="{{ route('posts.like', $post) }}" method="POST">
    @csrf
    <button type="submit" class="flex items-center text-gray-500 hover:text-red-500">
        <i class="far fa-heart mr-1"></i> {{ $post->likes ? $post->likes->count() : 0 }}
    </button>
</form>

<!-- Unlike Button -->
<form action="{{ route('posts.unlike', $post) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="flex items-center text-gray-500 hover:text-red-500">
        <i class="fas fa-heart mr-1"></i>
    </button>
</form>

                <!-- Share Button -->
                <form action="{{ route('posts.share', $post) }}" method="POST" class="flex items-center">
                    @csrf
                    <select name="recipient_id" class="p-2 border rounded-lg mr-2">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all">Share</button>
                </form>
            </div>

            <!-- Reply Form -->
            <form action="{{ route('replies.store', $post) }}" method="POST" class="mt-4">
                @csrf
                <textarea name="content" rows="2" class="w-full p-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Reply to this post..."></textarea>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg mt-2 hover:bg-green-600 transition-all">Reply</button>
            </form>

            <!-- Display Replies -->
            @foreach($post->replies as $reply)
                <div class="ml-4 mt-4 pl-4 border-l-2 border-gray-200">
                    <div class="flex items-center">
                        <span class="font-bold text-gray-800">{{ $reply->user->name }}</span>
                        <span class="text-sm text-gray-500 ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mt-2 text-gray-700">{{ $reply->content }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection