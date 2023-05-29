<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Web\UserController;

Route::resource('users', UserController::class)->middleware('auth');
