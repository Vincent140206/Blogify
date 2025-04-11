<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArtikelController;

// Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard (Kalau sudah Login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Form register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

// Submit register
Route::post('/register', [AuthController::class, 'register']);

// Form login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Submit login
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Form reset password
Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->middleware('auth')->name('password.change.form');

// Submit reset password
Route::post('/change-password', [AuthController::class, 'changePassword'])->middleware('auth')->name('password.change');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/artikel', [ArtikelController::class, 'index']);
});