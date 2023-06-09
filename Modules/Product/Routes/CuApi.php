<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\CuApi\V1\ProductController;

Route::prefix('v1/products')->group(function (){
    Route::get('index/{category_id}/{city_id}', [ProductController::class, 'index']);
    Route::get('show/{product_id}/{user_id}', [ProductController::class, 'show']);
    Route::get('search/{city_id}/{user_id}', [ProductController::class, 'search']);
    Route::get('related/{category_id}/{city_id}/{product_id}', [ProductController::class, 'related']);
});
