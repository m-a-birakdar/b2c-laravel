<?php

use Illuminate\Support\Facades\Route;
use Modules\Address\Http\Controllers\Api\V1\AddressController;

Route::prefix('v1')->middleware('auth:sanctum')->group(function (){
    Route::apiResource('addresses', AddressController::class);
});
