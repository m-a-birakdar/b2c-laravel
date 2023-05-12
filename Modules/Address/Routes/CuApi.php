<?php

use Illuminate\Support\Facades\Route;
use Modules\Address\Http\Controllers\CuApi\V1\AddressController;

Route::prefix('v1')->middleware('auth:sanctum')->group(function (){
    Route::apiResource('addresses', AddressController::class);
});
