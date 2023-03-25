<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\Web\OrderController;

Route::resource('orders', OrderController::class);
