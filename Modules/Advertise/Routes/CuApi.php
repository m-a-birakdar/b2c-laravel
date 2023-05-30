<?php

use Illuminate\Support\Facades\Route;
use Modules\Advertise\Http\Controllers\CuApi\V1\AdvertiseController;

Route::prefix('v1/advertises')->group(function (){
    Route::get('index/{type}/{user}', [AdvertiseController::class, 'index']);
    Route::get('one/{type}/{user}', [AdvertiseController::class, 'one']);
    Route::get('click/{id}/{user}', [AdvertiseController::class, 'click']);
    Route::get('views/{id}/{user}', [AdvertiseController::class, 'views']);
});
