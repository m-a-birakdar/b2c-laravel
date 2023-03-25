<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\Web\NotificationController;

Route::resource('notifications', NotificationController::class);
