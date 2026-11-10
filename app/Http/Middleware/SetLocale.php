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
     * dengan nilai 'id' atau 'en'. Nilai lain diabaikan (tetap bahasa bawaan).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale');

        if (in_array($locale, ['id', 'en'], true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
