<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\DaApi\CategoryReportController;
use Modules\Report\Http\Controllers\DaApi\MainReportController;
use Modules\Report\Http\Controllers\DaApi\ProductReportController;

Route::prefix('reports')->group(function (){
    Route::prefix('products')->group(function (){
        Route::get('show', [ProductReportController::class, 'show']);
        Route::get('index', [ProductReportController::class, 'index']);
        Route::get('compare-one', [ProductReportController::class, 'compareOne']);
        Route::get('compare-many', [ProductReportController::class, 'compareMany']);
    });
    Route::prefix('categories')->group(function (){
        Route::get('show', [CategoryReportController::class, 'show']);
        Route::get('index', [CategoryReportController::class, 'index']);
        Route::get('compare-one', [CategoryReportController::class, 'compareOne']);
        Route::get('compare-many', [CategoryReportController::class, 'compareMany']);
    });
    Route::prefix('main')->group(function (){
        Route::get('show', [MainReportController::class, 'show']);
        Route::get('index', [MainReportController::class, 'index']);
        Route::get('compare-one', [MainReportController::class, 'compareOne']);
        Route::get('compare-many', [MainReportController::class, 'compareMany']);
    });
});
