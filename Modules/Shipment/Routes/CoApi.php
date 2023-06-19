<?php

use Illuminate\Support\Facades\Route;
use Modules\Shipment\Http\Controllers\CoApi\V1\ShipmentController;

Route::prefix('v1/shipments')->middleware('auth:sanctum')->group(function (){
    Route::get('index/{status}', [ShipmentController::class, 'index'])->where('status', 'now|delivered');
    Route::get('show/{id}', [ShipmentController::class, 'show']);
});
