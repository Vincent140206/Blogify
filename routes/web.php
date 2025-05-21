<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\UserController;

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

Route::get('/forgot-password', function () { return view('auth.change-password'); })->name('password.forgot');

// Form recovery password
Route::get('/recovery', [AuthController::class, 'showRecoveryForm'])->name('password.recovery.form');

// Submit recovery password
Route::post('/recovery', [AuthController::class, 'recoverPassword'])->name('password.recovery');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/artikel', [ArtikelController::class, 'index']);
    
    Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/delete-account', [UserController::class, 'showDeleteForm'])->name('account.delete.form');
    Route::delete('/delete-account', [UserController::class, 'deleteAccount'])->name('account.delete');
});