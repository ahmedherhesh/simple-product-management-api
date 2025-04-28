<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class);
Route::patch('products/{product}/status', [ProductController::class, 'updateStatus']);
Route::post('products/{product}/update-images', [ProductController::class, 'updateImages']);