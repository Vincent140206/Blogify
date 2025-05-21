<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// =====================
// AUTH ROUTES
// =====================

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset & Recovery
Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->middleware('auth')->name('password.change.form');
Route::post('/change-password', [AuthController::class, 'changePassword'])->middleware('auth')->name('password.change');
Route::get('/forgot-password', function () {
    return view('auth.change-password');
})->name('password.forgot');

Route::get('/recovery', [AuthController::class, 'showRecoveryForm'])->name('password.recovery.form');
Route::post('/recovery', [AuthController::class, 'recoverPassword'])->name('password.recovery');

// =====================
// ROUTES WITH AUTH
// =====================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/artikel', [ArtikelController::class, 'index']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Blog
    Route::resource('blog', BlogController::class);
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create'); // opsional, karena sudah ditangani resource

    // Akun pengguna
    Route::get('/delete-account', [UserController::class, 'showDeleteForm'])->name('account.delete.form');
    Route::delete('/delete-account', [UserController::class, 'deleteAccount'])->name('account.delete');
    Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');

});