<?php

use Illuminate\Support\Facades\Route;
use Modules\Coupon\Http\Controllers\Web\CouponController;

Route::resource('coupons', CouponController::class);
