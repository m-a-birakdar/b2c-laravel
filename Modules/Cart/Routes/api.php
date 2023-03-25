<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\Api\V1\CartController;

Route::prefix('v1')->group(function (){
    Route::apiResource('carts', CartController::class);
});
