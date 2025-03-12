<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// ✅ Dashboard (Requires Authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ✅ Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Listings
Route::middleware('auth')->group(function () {
    Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
});

// ✅ Search Route
Route::get('/search', [SearchController::class, 'index'])->name('search');

// ✅ Chat Routes (Requires Authentication)

Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages']);
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
});

Route::get('/messages/{user}', [ChatController::class, 'getMessages'])->middleware('auth');

Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::post('/send-message', [ChatController::class, 'sendMessage'])->middleware('auth');
Route::get('/messages/{recipientId}', [ChatController::class, 'getMessages'])->middleware('auth');



// ✅ Auth Routes (Login, Register, etc.)
require __DIR__.'/auth.php';
