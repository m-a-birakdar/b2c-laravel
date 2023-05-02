<?php

use Illuminate\Support\Facades\Route;
use Modules\Support\Http\Controllers\Api\V1\SupportController;

Route::prefix('v1')->group(function (){
    Route::apiResource('supports', SupportController::class);
});
