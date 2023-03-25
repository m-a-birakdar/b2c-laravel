<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\Api\V1\OrderController;

Route::prefix('v1')->group(function (){
    Route::apiResource('orders', OrderController::class);
});
