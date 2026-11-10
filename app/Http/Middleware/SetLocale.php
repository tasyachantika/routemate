<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Terapkan bahasa antarmuka dari session.
     * Pilihan disimpan oleh route 'language.switch' sebagai session('locale')
     * dengan nilai salah satu dari: 'id', 'en', 'ja', 'ko', 'zh', 'ms'.
     * Nilai lain diabaikan (tetap bahasa bawaan).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale');

        if (in_array($locale, ['id', 'en', 'ja', 'ko', 'zh', 'ms'], true)) {
            app()->setLocale($locale);

            // Format tanggal (translatedFormat) ikut bahasa aktif.
            // Kode Carbon sama dengan kode locale aplikasi untuk
            // keenam bahasa ('zh' tetap 'zh' di Carbon).
            \Carbon\Carbon::setLocale($locale);
        }

        return $next($request);
    }
}
