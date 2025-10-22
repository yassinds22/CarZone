<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





// ---------------- Authentication ----------------

// Normal registration (email + password)
Route::post('register_by_email', [AuthController::class, 'register'])->name('api.register');

// تسجيل مستخدم عبر Google
Route::post('register/google', [AuthController::class, 'registerWithGoogle'])->name('api.register.google');

// تسجيل دخول (Email/Password أو Google ID)
Route::post('login', [AuthController::class, 'login'])->name('api.login');

// ---------------- Provinces Management ----------------
Route::apiResource('provinces', ProvinceController::class);

// ---------------- Brand Management ----------------
Route::apiResource('brands', BrandController::class);

// ---------------- Products Management ----------------
//Route::apiResource('products', ProductController::class)->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    // إنشاء منتج
    Route::post('products', [ProductController::class, 'store'])->name('products.store');

    // تحديث منتج
    Route::post('products/{id}', [ProductController::class, 'update'])->name('products.update');

    // حذف منتج
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// عمليات القراءة العامة (عرض المنتجات)
Route::apiResource('products', ProductController::class)
    ->only(['index','show']);

