<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\Http\Controllers\Web\InvoiceController;

Route::resource('invoices', InvoiceController::class);
