<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CoApi\V1\OrderController;

Route::prefix('v1/orders')->middleware('auth:sanctum')->group(function () {
    Route::get('show/{id}', [OrderController::class, 'show']);
    Route::get('to-delivered/{id}', [OrderController::class, 'toDelivered']);
});
