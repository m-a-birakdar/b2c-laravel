<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\Web\CartController;

Route::resource('carts', CartController::class);
