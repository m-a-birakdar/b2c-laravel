<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CuApi\V1\OrderController;

Route::prefix('v1/orders')->middleware('auth:sanctum')->group(function () {
    Route::post('save', [OrderController::class, 'save']);
    Route::get('index', [OrderController::class, 'index']);
    Route::get('show/{id}', [OrderController::class, 'show']);
    Route::post('review', [OrderController::class, 'review']);
});
