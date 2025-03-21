@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Add New Equipment Listing</h1>

    @if($errors->any())
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Tool Name</label>
            <input type="text" name="name" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Enter tool name">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Condition/Health</label>
            <input type="text" name="condition" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="e.g., Like New, Good, Fair">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Location</label>
            <input type="text" name="location" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Enter location">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Price (Rental)</label>
            <input type="number" name="price" step="0.01" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Enter price">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tool Image</label>
            <input type="file" name="image" class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <textarea name="description" rows="4" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Additional details"></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-all">Add Listing</button>
    </form>
</div>
@endsection
