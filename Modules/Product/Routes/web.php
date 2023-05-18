<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Web\ProductController;

    Route::get('data', function (\Modules\Product\Entities\Product $product){
        return $product->all()->toArray();
    });
Route::resource('products', ProductController::class)->middleware('auth');
