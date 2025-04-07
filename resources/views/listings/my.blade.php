<!-- resources/views/listings/my.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">My Listings</h1>

    @if($myListings->isEmpty())
        <p>You haven't posted any listings yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($myListings as $listing)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    @if($listing->image)
                        <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-700">No Image</span>
                        </div>
                    @endif
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $listing->name }}</h2>
                        <p class="text-sm text-gray-600 mt-1">Condition: {{ $listing->condition }}</p>
                        <p class="text-sm text-gray-600 mt-1">Location: {{ $listing->location }}</p>
                        <p class="text-lg text-gray-800 font-bold mt-2">Ksh {{ $listing->price }} per day</p>
                        <div class="mt-4">
                            <!-- Edit Button -->
                            <a href="{{ route('listings.edit', $listing->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-all">
                                Edit Listing
                            </a>

                            <!-- Delete Button Form -->
                            <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-all" onclick="return confirm('Are you sure you want to delete this listing?')">
                                    Delete Listing
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
