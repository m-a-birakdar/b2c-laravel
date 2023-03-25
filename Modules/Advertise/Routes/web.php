<?php

use Illuminate\Support\Facades\Route;
use Modules\Advertise\Http\Controllers\Web\AdvertiseController;

Route::resource('advertises', AdvertiseController::class);
