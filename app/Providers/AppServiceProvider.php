<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Prevents MySQL 1071 "Specified key was too long" on WAMP & Shared Hosting
        Schema::defaultStringLength(191);
    }
}
