<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    // Show the listings page
    public function index()
    {
        $listings = Listing::with('user')->latest()->get();
        return view('listings.index', compact('listings'));
    }

    // Show the form for creating a new listing
    public function create()
    {
        return view('listings.create');
    }

    // Store a new listing in the database
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'condition' => 'required|string',
        'location' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'nullable|string',
        'description' => 'nullable|string',
    ]);

    $validated['user_id'] = Auth::id(); // Add user ID before saving

    Listing::create($validated);

    return redirect()->route('listings.index')->with('success', 'Listing created successfully!');
}

public function myListings()
{
    $myListings = Listing::where('user_id', auth()->id())->latest()->get();
    return view('listings.my', compact('myListings'));
}

}
