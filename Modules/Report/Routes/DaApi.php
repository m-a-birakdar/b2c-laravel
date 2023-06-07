<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\DaApi\ProductReportController;

Route::prefix('reports')->group(function (){
    Route::prefix('products')->group(function (){
        Route::get('show', [ProductReportController::class, 'show']);
        Route::get('index', [ProductReportController::class, 'index']);
        Route::get('compare', [ProductReportController::class, 'compare']);
    });
});
