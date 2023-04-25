<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Api\V1\ProductController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware(['api', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class])->group(function () {
    Route::prefix('v1/products')->group(function (){
        Route::get('index/{category_id}', [ProductController::class, 'index']);
        Route::get('show/{product_id}', [ProductController::class, 'show']);
    });
});
