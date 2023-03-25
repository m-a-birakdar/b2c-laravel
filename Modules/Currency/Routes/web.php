<?php

use Illuminate\Support\Facades\Route;
use Modules\Currency\Http\Controllers\Web\CurrencyController;

Route::resource('currencies', CurrencyController::class);
