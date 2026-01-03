<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\ShippingController;

// --- Halaman Utama & Statis ---

// Route::get('/', function () { return view('welcome'); });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');


// --- Routes Fitur Shipping (Halaman Order) ---

Route::get('/order/{product}', [ShippingController::class, 'showOrderForm'])->name('order.form');
Route::post('/order/submit', [ShippingController::class, 'submitOrder'])->name('order.submit');


// --- API Routes untuk AJAX (Dipanggil oleh JavaScript) ---

Route::prefix('api')->group(function () {
    // 1. Ambil Provinsi
    Route::get('/provinces', [ShippingController::class, 'getProvinces']);
    
    // 2. Ambil Kota berdasarkan ID Provinsi
    Route::get('/cities/{provinceId}', [ShippingController::class, 'getCities']);
    
    // 3. Ambil Kecamatan berdasarkan ID Kota (INI YANG TADINYA HILANG)
    Route::get('/subdistricts/{cityId}', [ShippingController::class, 'getSubdistricts']);
    
    // 4. Hitung Ongkir
    Route::post('/calculate-shipping', [ShippingController::class, 'calculateShipping']);
});