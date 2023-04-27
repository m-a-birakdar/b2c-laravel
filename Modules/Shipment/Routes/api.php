<?php

use Illuminate\Support\Facades\Route;
use Modules\Shipment\Http\Controllers\Api\V1\ShipmentController;

Route::prefix('v1/shipments')->middleware('auth:sanctum')->group(function (){
    Route::get('show/{order_id}', [ShipmentController::class, 'show']);
});
