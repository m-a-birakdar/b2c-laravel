<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\CoApi\V1\AuthController;

Route::prefix('v1/auth')->group(function (){
    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
