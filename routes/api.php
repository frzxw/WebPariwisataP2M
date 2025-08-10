<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookingPageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CampingLocationController;
use App\Http\Controllers\PlotBookingController;
use App\Http\Controllers\EquipmentRentalController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlotBookingController as AdminPlotBookingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CampingLocationController as AdminCampingLocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// Public Routes
Route::prefix('public')->group(function () {
    // Homepage data
    Route::get('homepage', [HomepageController::class, 'index']);
    Route::get('homepage/carousels', [HomepageController::class, 'getLocationCarousels']);
    
    // Camping Locations
    Route::get('camping-locations', [CampingLocationController::class, 'index']);
    Route::get('camping-locations/{location}', [CampingLocationController::class, 'show']);
    Route::get('camping-locations/{location}/plots', [CampingLocationController::class, 'getPlots']);
    Route::post('camping-locations/{location}/check-availability', [CampingLocationController::class, 'checkAvailability']);
    
    // Equipment Rentals
    Route::get('equipment-rentals', [EquipmentRentalController::class, 'index']);
    Route::get('equipment-rentals/{equipment}', [EquipmentRentalController::class, 'show']);
    Route::get('equipment-rentals/category/{category}', [EquipmentRentalController::class, 'getByCategory']);
    Route::post('equipment-rentals/check-stock', [EquipmentRentalController::class, 'checkStock']);
    Route::post('equipment-rentals/calculate-cost', [EquipmentRentalController::class, 'calculateCost']);
    
    // Payment Methods
    Route::get('payment-methods', [PaymentController::class, 'getPaymentMethods']);
    
    // Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    
    // Reviews
    Route::get('reviews', [ReviewController::class, 'index']);
    Route::get('reviews/{review}', [ReviewController::class, 'show']);
    
    // Search
    Route::get('search/camping-locations', [SearchController::class, 'campingLocations']);
    Route::get('search/suggestions', [SearchController::class, 'suggestions']);
});

// Booking Page Routes
Route::prefix('booking-page')->group(function () {
    Route::get('/', [BookingPageController::class, 'show']);
    Route::get('facilities', [BookingPageController::class, 'getAvailableFacilities']);
    Route::post('check-availability', [BookingPageController::class, 'checkAvailability']);
});

// Protected Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {
    
    // Account Management
    Route::prefix('account')->group(function () {
        Route::get('profile', [AccountController::class, 'profile']);
        Route::put('profile', [AccountController::class, 'update']);
        Route::post('profile/picture', [AccountController::class, 'uploadProfilePicture']);
        Route::get('booking-history', [AccountController::class, 'bookingHistory']);
    });
    
    // Plot Bookings (Main camping booking system)
    Route::prefix('plot-bookings')->group(function () {
        Route::get('/', [PlotBookingController::class, 'index']);
        Route::post('/', [PlotBookingController::class, 'store']);
        Route::get('{booking}', [PlotBookingController::class, 'show']);
        Route::put('{booking}/cancel', [PlotBookingController::class, 'cancel']);
        Route::put('{booking}/status', [PlotBookingController::class, 'updateStatus']);
    });
    
    // Transactions
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'userTransactions']);
        Route::get('{booking}', [TransactionController::class, 'details']);
        Route::get('{booking}/receipt', [TransactionController::class, 'receipt']);
    });
    
    // Payments
    Route::prefix('payments')->group(function () {
        Route::post('{booking}/process', [PaymentController::class, 'processPayment']);
        Route::post('{booking}/upload-proof', [PaymentController::class, 'uploadProof']);
        Route::get('{booking}/status', [PaymentController::class, 'checkStatus']);
        Route::post('{booking}/refund', [PaymentController::class, 'requestRefund']);
    });
    
    // Reviews
    Route::prefix('reviews')->group(function () {
        Route::post('/', [ReviewController::class, 'store']);
        Route::put('{review}', [ReviewController::class, 'update']);
        Route::delete('{review}', [ReviewController::class, 'destroy']);
    });
    
    // File Uploads
    Route::prefix('uploads')->group(function () {
        Route::post('image', [FileUploadController::class, 'uploadImage']);
        Route::delete('image', [FileUploadController::class, 'deleteImage']);
    });
});

// Admin Routes (Require Admin Role)
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('dashboard/revenue-chart', [DashboardController::class, 'revenueChart']);
    Route::get('dashboard/booking-chart', [DashboardController::class, 'bookingChart']);
    Route::get('dashboard/location-chart', [DashboardController::class, 'locationChart']);
    
    // User Management
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index']);
        Route::post('/', [AdminUserController::class, 'store']);
        Route::get('statistics', [AdminUserController::class, 'statistics']);
        Route::get('{user}', [AdminUserController::class, 'show']);
        Route::put('{user}', [AdminUserController::class, 'update']);
        Route::put('{user}/toggle-status', [AdminUserController::class, 'toggleStatus']);
        Route::delete('{user}', [AdminUserController::class, 'destroy']);
    });
    
    // Camping Location Management
    Route::prefix('camping-locations')->group(function () {
        Route::get('/', [AdminCampingLocationController::class, 'index']);
        Route::post('/', [AdminCampingLocationController::class, 'store']);
        Route::get('{location}', [AdminCampingLocationController::class, 'show']);
        Route::put('{location}', [AdminCampingLocationController::class, 'update']);
        Route::delete('{location}', [AdminCampingLocationController::class, 'destroy']);
        Route::put('{location}/toggle-status', [AdminCampingLocationController::class, 'toggleStatus']);
    });
    
    // Plot Booking Management
    Route::prefix('plot-bookings')->group(function () {
        Route::get('/', [AdminPlotBookingController::class, 'index']);
        Route::get('statistics', [AdminPlotBookingController::class, 'statistics']);
        Route::get('export', [AdminPlotBookingController::class, 'export']);
        Route::get('{booking}', [AdminPlotBookingController::class, 'show']);
        Route::put('{booking}/status', [AdminPlotBookingController::class, 'updateStatus']);
        Route::put('{booking}/payment-status', [AdminPlotBookingController::class, 'updatePaymentStatus']);
        Route::put('{booking}/cancel', [AdminPlotBookingController::class, 'cancel']);
        Route::put('payments/{paymentLog}/verify', [AdminPlotBookingController::class, 'verifyPayment']);
    });
    
    // Review Management
    Route::prefix('reviews')->group(function () {
        Route::get('/', [ReviewController::class, 'index']);
        Route::post('{review}/approve', [ReviewController::class, 'approve']);
        Route::delete('{review}', [ReviewController::class, 'destroy']);
    });
});

// Payment Webhooks (No authentication required)
Route::post('webhooks/payment', [PaymentController::class, 'webhook']);
