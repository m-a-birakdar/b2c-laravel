<?php

use Illuminate\Support\Facades\Route;
use Modules\Currency\Http\Controllers\Api\V1\CurrencyController;

Route::prefix('v1')->group(function (){
    Route::apiResource('currencies', CurrencyController::class);
});
