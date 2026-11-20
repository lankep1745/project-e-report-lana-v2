<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvidenceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - LaporinYuk! (E-Report)
|--------------------------------------------------------------------------
*/

// Home / Landing redirects to reports or dashboard
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('reports.index');
    }

    return redirect()->route('login');
})->name('home');

// Guest Authentication Routes (with rate-limiting on register & login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User Portal (Split View: Create & Track Reports)
    Route::get('/laporan', function () {
        return view('reports.index');
    })->name('reports.index');

    // Private Evidence Retrieval (Authorized for owner & admin only)
    Route::get('/evidence/{report}', [EvidenceController::class, 'show'])->name('evidence.show');

    // Admin Dashboard (Protected by EnsureAdmin middleware)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });
});
