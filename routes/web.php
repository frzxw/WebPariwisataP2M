<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\WebAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Main Web Pages
Route::get('/', [WebController::class, 'homepage'])->name('web.homepage');
Route::get('/about', [WebController::class, 'about'])->name('web.about');

// Protected pages that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/transaction', [WebController::class, 'transaction'])->name('web.transaction');
    Route::get('/account', [WebController::class, 'account'])->name('web.account');
    Route::put('/account/profile', [WebController::class, 'updateProfile'])->name('web.account.update');
});

// Guest Routes (Login/Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('web.login');
    Route::post('/login', [WebAuthController::class, 'login'])->name('web.login.post');
    Route::get('/register', [WebAuthController::class, 'showRegisterForm'])->name('web.register');
    Route::post('/register', [WebAuthController::class, 'register'])->name('web.register.post');
});

Route::post('/logout', [WebAuthController::class, 'logout'])->name('web.logout')->middleware('auth');

// Booking Routes
Route::get('/booking', [WebController::class, 'booking'])->name('web.booking');
Route::middleware('auth')->group(function () {
    Route::post('/booking', [BookingController::class, 'store'])->name('web.booking.store');
    Route::get('/booking/confirmation/{bookingCode}', [BookingController::class, 'confirmation'])->name('web.booking.confirmation');
    Route::get('/booking/payment/{bookingCode}', [BookingController::class, 'payment'])->name('web.booking.payment');
    Route::post('/booking/payment/{bookingCode}', [BookingController::class, 'processPayment'])->name('web.booking.payment.process');
});
Route::post('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('web.booking.check-availability');
Route::post('/booking/equipment-details', [BookingController::class, 'getEquipmentDetails'])->name('web.booking.equipment-details');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [WebAuthController::class, 'adminLogin'])->name('login.post');
    
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/transactions', [App\Http\Controllers\AdminController::class, 'transactions'])->name('transactions');
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
        Route::get('/items', [App\Http\Controllers\AdminController::class, 'items'])->name('items');
        
        // AJAX routes for admin actions
        Route::patch('/bookings/{booking}/status', [App\Http\Controllers\AdminController::class, 'updateBookingStatus'])->name('bookings.updateStatus');
        Route::patch('/users/{user}/toggle-status', [App\Http\Controllers\AdminController::class, 'toggleUserStatus'])->name('users.toggleStatus');
    });
});
