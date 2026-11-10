<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DestinationController as AdminDestinationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ItineraryDetailController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripBudgetController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\VerifyEmailController;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $destinations = Destination::with('category')->latest()->take(6)->get();

    return view('home', compact('destinations'));
})->name('home');

// Pengalih bahasa antarmuka (Indonesia, Inggris, Jepang, Korea, Mandarin,
// Melayu). Selalu bisa diakses, pilihan disimpan di session lalu diterapkan
// middleware SetLocale.
Route::get('/language/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en', 'ja', 'ko', 'zh', 'ms'], true)) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('language.switch');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1');

    Route::get('/forgot-password', [PasswordResetController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendLink'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        $tripsCount = auth()->user()->trips()->count();
        $destinationsCount = Destination::count();

        return view('dashboard', compact('tripsCount', 'destinationsCount'));
    })->name('dashboard');

    // Verifikasi email: halaman pemberitahuan + kirim ulang + tautan verifikasi.
    // Route TIDAK dikunci dengan middleware 'verified' agar akun demo tetap bisa dipakai.
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');

    Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('password.change');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.change.update');

    Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
    Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');
    Route::get('/map', [MapController::class, 'index'])->name('map.index');

    Route::resource('trips', TripController::class);
    Route::post('/trips/{trip}/details', [ItineraryDetailController::class, 'store'])->name('trips.details.store');
    Route::put('/trips/{trip}/details/{detail}', [ItineraryDetailController::class, 'update'])->name('trips.details.update');
    Route::delete('/trips/{trip}/details/{detail}', [ItineraryDetailController::class, 'destroy'])->name('trips.details.destroy');
    Route::post('/trips/{trip}/details/{detail}/move', [ItineraryDetailController::class, 'move'])->name('trips.details.move');

    Route::post('/trips/{trip}/budgets', [TripBudgetController::class, 'store'])->name('trips.budgets.store');
    Route::put('/trips/{trip}/budgets/{budget}', [TripBudgetController::class, 'update'])->name('trips.budgets.update');
    Route::delete('/trips/{trip}/budgets/{budget}', [TripBudgetController::class, 'destroy'])->name('trips.budgets.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'destinationsCount' => Destination::count(),
            'categoriesCount' => Category::count(),
            'usersCount' => User::count(),
            'tripsCount' => Trip::count(),
        ]);
    })->name('dashboard');

    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('destinations', AdminDestinationController::class)->except('show');

    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');

    Route::get('/activity', [ActivityLogController::class, 'index'])->name('activity');
});
