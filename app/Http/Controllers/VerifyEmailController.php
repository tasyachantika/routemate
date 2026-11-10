<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Tandai email pengguna sebagai terverifikasi dari tautan di email.
     * Tautan ini bertanda tangan digital (signed URL) dan hanya berlaku
     * untuk akun pemiliknya.
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('dashboard')->with('success', 'Email kamu berhasil diverifikasi. Terima kasih!');
    }
}
