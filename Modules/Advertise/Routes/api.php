<?php

use Illuminate\Support\Facades\Route;
use Modules\Advertise\Http\Controllers\Api\V1\AdvertiseController;

Route::prefix('v1')->group(function (){
    Route::apiResource('advertises', AdvertiseController::class);
});
