<?php

use Illuminate\Support\Facades\Route;
use Modules\Advertise\Http\Controllers\CuApi\V1\AdvertiseController;

Route::prefix('v1/advertises')->group(function (){
    Route::get('index/{type}', [AdvertiseController::class, 'index']);
    Route::get('one/{type}', [AdvertiseController::class, 'one']);
    Route::get('click/{id}', [AdvertiseController::class, 'click']);
});
