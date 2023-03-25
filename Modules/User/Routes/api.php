<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\V1\UserController;

Route::prefix('v1')->group(function (){
    Route::apiResource('users', UserController::class);
});
