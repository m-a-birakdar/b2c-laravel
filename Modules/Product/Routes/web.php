<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Web\ProductController;

Route::resource('products', ProductController::class)->middleware('auth');
