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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // image validation
        'description' => 'nullable|string',
    ]);

    // Handle image upload if present
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('public', 'public'); // Save image to public/storage
    } else {
        $imagePath = null;
    }

    $validated['user_id'] = Auth::id(); // Add user ID before saving
    $validated['image'] = $imagePath; // Save the image path


    Listing::create($validated);


    return redirect()->route('listings.index')->with('success', 'Listing created successfully!');
}

public function myListings()
{
    $myListings = Listing::where('user_id', auth()->id())->latest()->get();
    return view('listings.my', compact('myListings'));
}

// Show the form for editing the listing
public function edit(Listing $listing)
{
    // Ensure the authenticated user is the owner of the listing
    if ($listing->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    return view('listings.edit', compact('listing'));
}

// Delete the listing
public function destroy(Listing $listing)
{
    // Ensure the authenticated user is the owner of the listing
    if ($listing->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Delete the image from storage if it exists
    if ($listing->image) {
        Storage::delete('public/' . $listing->image);
    }

    // Delete the listing from the database
    $listing->delete();

    return redirect()->route('listings.my')->with('success', 'Listing deleted successfully!');
}

// ListingController.php

// Update the listing
public function update(Request $request, Listing $listing)
{
    // Ensure the authenticated user is the owner of the listing
    if ($listing->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'condition' => 'required|string',
        'location' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'description' => 'nullable|string',
    ]);

    // Handle image upload if present
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($listing->image) {
            Storage::delete('public/' . $listing->image);
        }

        $imagePath = $request->file('image')->store('listings', 'public');
        $validated['image'] = $imagePath;
    }

    // Update the listing
    $listing->update($validated);

    return redirect()->route('listings.my')->with('success', 'Listing updated successfully!');
}


}
