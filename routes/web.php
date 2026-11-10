<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DestinationController as AdminDestinationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ItineraryDetailController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TripController;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $destinations = Destination::with('category')->latest()->take(6)->get();

    return view('home', compact('destinations'));
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        $tripsCount = auth()->user()->trips()->count();
        $destinationsCount = Destination::count();

        return view('dashboard', compact('tripsCount', 'destinationsCount'));
    })->name('dashboard');

    Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
    Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');
    Route::get('/map', [MapController::class, 'index'])->name('map.index');

    Route::resource('trips', TripController::class);
    Route::post('/trips/{trip}/details', [ItineraryDetailController::class, 'store'])->name('trips.details.store');
    Route::put('/trips/{trip}/details/{detail}', [ItineraryDetailController::class, 'update'])->name('trips.details.update');
    Route::delete('/trips/{trip}/details/{detail}', [ItineraryDetailController::class, 'destroy'])->name('trips.details.destroy');
    Route::post('/trips/{trip}/details/{detail}/move', [ItineraryDetailController::class, 'move'])->name('trips.details.move');
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
});
