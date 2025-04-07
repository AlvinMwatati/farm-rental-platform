<!-- resources/views/listings/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Edit Listing</h1>

    <form action="{{ route('listings.edit', $listing->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700">Tool Name</label>
            <input type="text" name="name" value="{{ $listing->name }}" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Enter tool name">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Condition/Health</label>
            <input type="text" name="condition" value="{{ $listing->condition }}" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="e.g., Like New, Good, Fair">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Location</label>
            <input type="text" name="location" value="{{ $listing->location }}" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Enter location">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Price (Rental)</label>
            <input type="number" name="price" value="{{ $listing->price }}" step="0.01" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Enter price">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tool Image</label>
            <input type="file" name="image" class="w-full p-2 border rounded">
            @if($listing->image)
                <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->name }}" class="mt-2 w-32 h-32 object-cover">
            @endif
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <textarea name="description" rows="4" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Additional details">{{ $listing->description }}</textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-all">Update Listing</button>
    </form>
</div>
@endsection
