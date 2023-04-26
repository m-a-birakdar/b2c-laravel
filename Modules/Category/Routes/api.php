<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Api\V1\CategoryController;

Route::prefix('v1/categories')->group(function (){
    Route::get('main', [CategoryController::class, 'main']);
    Route::get('sub/{category_id}', [CategoryController::class, 'sub']);
});
