<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Facades\Filament;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()?->canAccessFilament()) {
            return redirect('/admin/dashboard'); // Direct to Filament dashboard
        }

        abort(403, 'Unauthorized'); // Prevents looping
    }
}
