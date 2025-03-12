<?php
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Example: Search in listings
        $results = Listing::where('title', 'LIKE', "%{$query}%")->get();

        return view('search-results', compact('results', 'query'));
    }
}
