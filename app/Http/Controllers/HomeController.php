<?php
namespace App\Http\Controllers;
use App\Models\Listing;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $listings = Listing::latest()->take(6)->get(); // Show latest 6 listings
        return view('home', compact('listings'));
    }
    
}
