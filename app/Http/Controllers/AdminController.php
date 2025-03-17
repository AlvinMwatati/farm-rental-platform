<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Facades\Filament;

class AdminController extends Controller
{
    public function index()
    {
        // Redirect to Filament admin dashboard
        return redirect(Filament::getPanel('admin')->getUrl());
    }
}