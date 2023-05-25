<?php

use Illuminate\Support\Facades\Route;
use Modules\Coupon\Http\Controllers\CuApi\V1\CouponController;

Route::prefix('v1/coupons')->group(function (){
    Route::post('check', [CouponController::class, 'check']);
});
