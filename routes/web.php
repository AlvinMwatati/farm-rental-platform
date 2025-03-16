<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire; // ✅ Ensure Livewire is included
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SharedPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use App\Http\Livewire\Chat; // ✅ Ensure Chat Livewire Component is included


// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');

// Protected routes (Require Authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ✅ Use Livewire Component for Chat Instead of Controller
    Route::get('/chat', function () {
        return view('chat'); // ✅ Ensure 'profile.chat' includes @livewire('chat')
    })->name('chat.index');

    // Forum Route
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
});

// Posts
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

// Replies
Route::post('/posts/{post}/replies', [ReplyController::class, 'store'])->name('replies.store');
Route::delete('/replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');

Route::get('/forum', [PostController::class, 'index'])->name('forum');

// Likes
Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
Route::delete('/posts/{post}/unlike', [LikeController::class, 'destroy'])->name('posts.unlike');

// Shared Posts
Route::post('/posts/{post}/share', [SharedPostController::class, 'store'])->name('posts.share');
// Authentication Routes (Login/Register)
require __DIR__.'/auth.php';
