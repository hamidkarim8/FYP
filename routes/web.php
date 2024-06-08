<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SimpleReportController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

// Landing page route accessible to all users
Route::get('/', [HomeController::class, 'root'])->name('root');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot-password-form');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Admin Dashboard Route
Route::get('/admin', [AdminController::class, 'adminIndex'])->middleware(['auth', 'role:admin'])->name('admin.index');

// User Home Route
Route::get('/home', [UserController::class, 'userIndex'])->middleware(['auth', 'role:normal_user'])->name('user.index');

// Profile Routes
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::get('/user-profile', [ProfileController::class, 'showUserProfile'])->name('user.profile');
Route::post('/update-profile/{id}', [ProfileController::class, 'update'])->name('updateProfile');
Route::post('/update-socialmedia/{id}', [ProfileController::class, 'updateSocialMedia'])->name('updateSocialMedia');
Route::post('/update-avatar/{id}', [ProfileController::class, 'updateAvatar'])->name('updateAvatar');
Route::post('/update-password/{id}', [ProfileController::class, 'changePassword'])->name('changePassword');

//Item Detail Route
Route::get('/item-detail', [ItemController::class, 'itemDetail'])->name('user.itemDetail');

//Simple Report
Route::post('/simple-report', [SimpleReportController::class, 'store'])->name('simple-reports.store');
Route::post('/simple-report-display', [SimpleReportController::class, 'show'])->name('simple-reports.show');


// Fallback Route
Route::fallback(function () {
    return redirect()->route('root');
});
