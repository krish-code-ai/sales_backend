<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/orders', [OrderController::class, 'index']);
Route::get('/locations', [OrderController::class, 'locations']);
Route::get('/orders/summary', [OrderController::class, 'summary']);



Route::apiResource('categories', ItemCategoryController::class);

Route::apiResource('customer', CustomerController::class);
