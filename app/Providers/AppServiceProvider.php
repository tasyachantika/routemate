<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Format tanggal (nama bulan/hari) mengikuti Bahasa Indonesia,
        // misalnya "10 November 2026".
        Carbon::setLocale('id');
    }
}
