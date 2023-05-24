<?php

use Illuminate\Support\Facades\Route;
use Modules\Currency\Http\Controllers\AdApi\V1\CurrencyController;

Route::prefix('v1/currencies')->group(function (){
    Route::get('show/{id}', [CurrencyController::class, 'show']);
});
