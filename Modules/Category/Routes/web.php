<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Web\CategoryController;

Route::resource('categories', CategoryController::class);
