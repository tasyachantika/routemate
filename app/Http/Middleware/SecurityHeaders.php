<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menambahkan header keamanan HTTP pada setiap respons.
 *
 * Header ini memerintahkan browser untuk:
 * - tidak menebak tipe konten (anti MIME-sniffing),
 * - melarang situs lain membingkai RouteMate (anti clickjacking),
 * - membatasi informasi referrer yang dikirim ke situs lain,
 * - mematikan akses kamera/mikrofon/lokasi yang tidak dipakai aplikasi,
 * - memaksa HTTPS selama satu tahun (hanya dikirim bila koneksi sudah HTTPS).
 *
 * Content-Security-Policy sengaja belum dipasang: RouteMate memuat
 * Bootstrap, font, dan ubin peta dari CDN pihak ketiga, sehingga CSP
 * harus disusun dan diuji khusus agar tidak mematahkan tampilan/peta.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
