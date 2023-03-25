<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\Api\V1\NotificationController;

Route::prefix('v1')->group(function (){
    Route::apiResource('notifications', NotificationController::class);
});
