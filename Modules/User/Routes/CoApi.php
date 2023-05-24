<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\CoApi\V1\AuthController;
use Modules\User\Http\Controllers\CuApi\V1\ProfileController;

Route::prefix('v1/users')->group(function (){
    Route::prefix('auth')->group(function (){
        Route::post('login', [AuthController::class, 'login']);
        Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });
    Route::prefix('profile')->middleware('auth:sanctum')->group(function (){
        Route::post('update', [ProfileController::class, 'update']);
        Route::post('update-password', [ProfileController::class, 'updatePassword']);
    });
});
