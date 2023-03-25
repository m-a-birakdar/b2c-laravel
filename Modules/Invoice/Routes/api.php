<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\Http\Controllers\Api\V1\InvoiceController;

Route::prefix('v1')->group(function (){
    Route::apiResource('invoices', InvoiceController::class);
});
