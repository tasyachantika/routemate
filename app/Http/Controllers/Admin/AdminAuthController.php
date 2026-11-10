<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TurnstileVerifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // CAPTCHA diverifikasi di server SEBELUM password diperiksa,
        // sama seperti login pengguna biasa.
        $this->ensureTurnstile($request);

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => __('Email atau password salah.'),
            ]);
        }

        if (! $request->user()->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => __('Email atau password salah.'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    private function ensureTurnstile(Request $request): void
    {
        $token = $request->input('cf-turnstile-response');

        if (! app(TurnstileVerifier::class)->verify($token, $request->ip())) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => __('Verifikasi CAPTCHA gagal atau belum selesai. Silakan coba lagi.'),
            ]);
        }
    }
}
