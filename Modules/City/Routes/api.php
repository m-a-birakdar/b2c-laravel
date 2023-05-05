<?php

use Illuminate\Support\Facades\Route;
use Modules\City\Http\Controllers\Api\V1\CityController;

Route::prefix('v1/cities')->group(function (){
    Route::get('index', [CityController::class, 'index']);
});
