<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Api\V1\CategoryController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware(['api', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class])->group(function () {
    Route::prefix('v1/categories')->group(function (){
        Route::get('main', [CategoryController::class, 'main']);
        Route::get('sub/{category_id}', [CategoryController::class, 'sub']);
    });
});
