<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Api\V1\CategoryController;

Route::prefix('v1')->group(function (){
    Route::apiResource('categories', CategoryController::class);
});
