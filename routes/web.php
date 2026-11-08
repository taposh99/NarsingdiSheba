<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
