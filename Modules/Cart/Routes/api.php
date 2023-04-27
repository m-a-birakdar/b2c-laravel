<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\Api\V1\CartController;

Route::prefix('v1/carts')->middleware('auth:sanctum')->group(function () {
    Route::get('index', [CartController::class, 'index']);
    Route::get('checkout', [CartController::class, 'checkout']);
    Route::get('add/{product_id}', [CartController::class, 'add']);
    Route::get('remove/{product_id}', [CartController::class, 'remove']);
});
