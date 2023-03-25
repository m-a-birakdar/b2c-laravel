<?php

use Illuminate\Support\Facades\Route;
use Modules\Coupon\Http\Controllers\Api\V1\CouponController;

Route::prefix('v1')->group(function (){
    Route::apiResource('coupons', CouponController::class);
});
