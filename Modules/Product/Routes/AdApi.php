<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\AdApi\V1\ProductController;

Route::prefix('v1/products')->group(function (){
    Route::get('index/{category_id}/{city_id}', [ProductController::class, 'index']);
    Route::get('show/{product_id}', [ProductController::class, 'show']);
    Route::put('update/{product_id}', [ProductController::class, 'show']);
});
