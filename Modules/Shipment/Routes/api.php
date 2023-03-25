<?php

use Illuminate\Support\Facades\Route;
use Modules\Shipment\Http\Controllers\Api\V1\ShipmentController;

Route::prefix('v1')->group(function (){
    Route::apiResource('shipments', ShipmentController::class);
});
