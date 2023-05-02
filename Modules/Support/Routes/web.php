<?php

use Illuminate\Support\Facades\Route;
use Modules\Support\Http\Controllers\Web\SupportController;

Route::resource('supports', SupportController::class);
