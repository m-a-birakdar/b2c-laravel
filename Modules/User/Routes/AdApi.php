<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AdApi\V1\AuthController;
use Modules\User\Http\Controllers\AdApi\V1\UserController;
use Modules\User\Http\Controllers\CuApi\V1\ProfileController;

Route::prefix('v1/users')->middleware('auth:sanctum')->group(function (){
    Route::prefix('auth')->group(function (){
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
        Route::get('logout', [AuthController::class, 'logout']);
    });
    Route::middleware('auth:sanctum')->group(function (){
        Route::get('couriers', [UserController::class, 'couriers']);
        Route::prefix('profile')->group(function (){
            Route::post('update', [ProfileController::class, 'update']);
            Route::post('update-password', [ProfileController::class, 'updatePassword']);
        });
    });
});
