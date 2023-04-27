<?php

use Illuminate\Support\Facades\Route;
use Modules\Address\Http\Controllers\Web\AddressController;

Route::resource('addresses', AddressController::class);
