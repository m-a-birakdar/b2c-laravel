<?php

use Illuminate\Support\Facades\Route;
use Modules\City\Http\Controllers\Web\CityController;

Route::resource('cities', CityController::class);
