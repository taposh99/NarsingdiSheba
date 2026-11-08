<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdController;

// Public Front Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/emergency', [HomeController::class, 'emergency'])->name('emergency');
Route::get('/blood', [HomeController::class, 'blood'])->name('blood');
Route::post('/blood/register', [HomeController::class, 'storeBloodDonor'])->name('blood.register');
Route::get('/doctors', [HomeController::class, 'doctors'])->name('doctors');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/workers', [HomeController::class, 'workers'])->name('workers');
Route::get('/jobs', [HomeController::class, 'jobs'])->name('jobs');
Route::post('/jobs/create', [HomeController::class, 'storeJob'])->name('jobs.store');
Route::get('/market-prices', [HomeController::class, 'marketPrices'])->name('prices');
Route::get('/places', [HomeController::class, 'places'])->name('places');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Advertisement Public Routes
Route::get('/advertise', [AdController::class, 'index'])->name('advertise');
Route::post('/advertise/submit', [AdController::class, 'submitAdRequest'])->name('ad.submit');

// Cart & Checkout Routes
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/order-success/{orderNumber}', [CartController::class, 'orderSuccess'])->name('order.success');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Dashboard & Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/toggle-donor', [DashboardController::class, 'toggleDonorStatus'])->name('dashboard.toggle_donor');

    // Admin Management Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::post('/tickers', [AdminController::class, 'storeTicker'])->name('tickers.store');
        Route::post('/tickers/{id}/toggle', [AdminController::class, 'toggleTicker'])->name('tickers.toggle');
        Route::delete('/tickers/{id}', [AdminController::class, 'deleteTicker'])->name('tickers.delete');

        Route::post('/prices', [AdminController::class, 'storePrice'])->name('prices.store');
        Route::post('/prices/{id}/update', [AdminController::class, 'updatePrice'])->name('prices.update');
        Route::delete('/prices/{id}', [AdminController::class, 'deletePrice'])->name('prices.delete');

        Route::post('/emergency', [AdminController::class, 'storeEmergency'])->name('emergency.store');
        Route::delete('/emergency/{id}', [AdminController::class, 'deleteEmergency'])->name('emergency.delete');

        Route::post('/doctors', [AdminController::class, 'storeDoctor'])->name('doctors.store');
        Route::delete('/doctors/{id}', [AdminController::class, 'deleteDoctor'])->name('doctors.delete');

        Route::delete('/donors/{id}', [AdminController::class, 'deleteDonor'])->name('donors.delete');

        Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');

        Route::post('/jobs/{id}/toggle', [AdminController::class, 'toggleJob'])->name('jobs.toggle');
        Route::delete('/jobs/{id}', [AdminController::class, 'deleteJob'])->name('jobs.delete');

        // Advertisement Admin Routes
        Route::post('/ads/{id}/toggle', [AdController::class, 'toggleStatus'])->name('ads.toggle');
        Route::delete('/ads/{id}', [AdController::class, 'deleteAd'])->name('ads.delete');

        // Order Management
        Route::post('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

        // User Role & Permissions Management (Super Admin)
        Route::post('/users/{id}/permissions', [AdminController::class, 'updateUserPermissions'])->name('users.permissions');
    });
});
