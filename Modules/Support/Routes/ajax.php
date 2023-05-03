<?php

use Illuminate\Support\Facades\Route;
use Modules\Support\Http\Controllers\Ajax\SupportController;

Route::get('load-users', [SupportController::class, 'loadUsers'])->name('load-users')->middleware('auth');
