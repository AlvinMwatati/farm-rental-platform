<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class FilamentAdminProvider extends ServiceProvider
{
    public function boot()
    {
        Filament::serving(function () {
            Gate::define('accessFilament', function ($user) {
                return $user->is_admin ?? false; // Ensure the 'is_admin' column exists in users table
            });
        });
    }
}
