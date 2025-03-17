<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SharedPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ListingAdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Providers\FillamentServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Chat;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');

// Protected Routes (Authenticated Users Only)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/chat', function () {
        return view('chat');
    })->name('chat.index');

    // Forum
    Route::get('/forum', [PostController::class, 'index'])->name('forum');

    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Replies
    Route::post('/posts/{post}/replies', [ReplyController::class, 'store'])->name('replies.store');
    Route::delete('/replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');

    // Likes
    Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
    Route::delete('/posts/{post}/unlike', [LikeController::class, 'destroy'])->name('posts.unlike');

    // Share Post
    Route::post('/posts/share', [PostController::class, 'sharePost'])->name('posts.share');

    // Get Users for Sharing
    Route::get('/users/list', function () {
        return response()->json(['users' => User::select('id', 'name')->get()]);
    })->name('users.list');
});

Route::middleware(['auth', 'can:accessFilament'])->group(function () {
    Route::get('/admin', function () {
        return redirect()->route('filament.admin.pages.dashboard');
    })->name('admin.dashboard');
});


// Admin Routes (Only Admins)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // // Listings Management
    // Route::prefix('/admin/listings')->group(function () {
    //     Route::get('/', [ListingAdminController::class, 'index'])->name('admin.listings');
    //     Route::get('/create', [ListingAdminController::class, 'create'])->name('admin.listings.create');
    //     Route::post('/', [ListingAdminController::class, 'store'])->name('admin.listings.store');
    //     Route::get('/{id}/edit', [ListingAdminController::class, 'edit'])->name('admin.listings.edit');
    //     Route::put('/{id}', [ListingAdminController::class, 'update'])->name('admin.listings.update');
    //     Route::delete('/{id}', [ListingAdminController::class, 'destroy'])->name('admin.listings.destroy');
    // });
});

// Authentication Routes
require __DIR__.'/auth.php';
