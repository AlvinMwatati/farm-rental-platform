<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class FilamentAdminProvider extends ServiceProvider
{
    public function boot()
    {
        Filament::serving(function () {
            Gate::define('access-filament', function ($user) {
                return $user->isAdmin();
            });

            // This simply ensures that a user is logged in.
            Filament::auth(fn () => Auth::check());
        });
    }
}
