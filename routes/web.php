<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MyArticlesController;
use App\Http\Controllers\SettingsController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// =====================
// AUTH ROUTES
// =====================
Route::get('/test-auth', function () {
    return auth()->check() ? 'Logged in' : 'Not logged in';
});

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', [DashboardController::class, 'index'])->name('dashboard.search');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Blog
    Route::resource('blog', BlogController::class);
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create'); // opsional, karena sudah ditangani resource

    // Akun pengguna
    Route::get('/delete-account', [UserController::class, 'showDeleteForm'])->name('account.delete.form');
    Route::delete('/delete-account', [UserController::class, 'deleteAccount'])->name('account.delete');
    Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');

    // ===================
    // BLOG
    // ===================

    // My blogs routes
    Route::get('/my-blogs', [ArticleController::class, 'myBlogs'])->name('articles.my-blogs');
    
    // CRUD routes
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    // Comment routes
    // Store a new comment
    Route::post('/articles/{article}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    
    // Update a comment
    Route::put('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
    
    // Delete a comment
    Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
    Route::post('/settings/avatar', [SettingsController::class, 'uploadAvatar'])->name('settings.upload-avatar');
    Route::delete('/settings/avatar', [SettingsController::class, 'removeAvatar'])->name('settings.remove-avatar');
    Route::put('/settings/email', [SettingsController::class, 'updateEmail'])->name('settings.update-email');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
    Route::post('/settings/logout-devices', [SettingsController::class, 'logoutAllDevices'])->name('settings.logout-all-devices');
    Route::delete('/settings/account', [SettingsController::class, 'deleteAccount'])->name('settings.delete-account');

});

// Blog
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/my-blogs', [MyArticlesController::class, 'index']) ->name('articles.my-blogs') ->middleware('auth');