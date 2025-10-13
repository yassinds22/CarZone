<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('auth', AuthController::class);
Route::apiResource('users', AuthController::class)->only(['show']);
Route::apiResource('allData', AuthController::class);

Route::post('login',[AuthController::class,'login']);
