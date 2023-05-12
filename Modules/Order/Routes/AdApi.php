<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\AdApi\V1\OrderController;

Route::prefix('v1/orders')->middleware('auth:sanctum')->group(function () {
    Route::get('index/{status}', [OrderController::class, 'index']);
    Route::get('change/{status}', [OrderController::class, 'change']);
});