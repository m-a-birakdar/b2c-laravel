<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\CuApi\V1\NotificationController;

Route::prefix('v1/notifications')->middleware('auth:sanctum')->group(function () {
    Route::get('index/{type?}', [NotificationController::class, 'index']);
    Route::get('read/{id?}', [NotificationController::class, 'read']);
});
