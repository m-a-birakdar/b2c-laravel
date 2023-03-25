<?php

use Illuminate\Support\Facades\Route;
use Modules\Shipment\Http\Controllers\Web\ShipmentController;

Route::resource('shipments', ShipmentController::class);
