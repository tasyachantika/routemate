<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
        // Batas panjang kolom string terindeks: server MySQL bersama
        // (InfinityFree) membatasi panjang kunci indeks maks 1000 byte,
        // sehingga varchar(255) utf8mb4 (1020 byte) ditolak (error 1071).
        // 191 karakter x 4 byte = 764 byte, aman di semua engine.
        Schema::defaultStringLength(191);

        // Format tanggal (nama bulan/hari) mengikuti Bahasa Indonesia,
        // misalnya "10 November 2026".
        Carbon::setLocale('id');
    }
}
