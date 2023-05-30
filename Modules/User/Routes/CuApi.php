<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\CuApi\V1\{AuthController,
    FavoriteController,
    ProfileController,
    ResetPasswordController};

Route::prefix('v1/users')->group(function (){
    Route::prefix('auth')->group(function (){
        Route::post('send-otp', [AuthController::class, 'sendOtp']);
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('welcome', [AuthController::class, 'welcome']);
        Route::middleware('auth:sanctum')->group(function (){
            Route::get('logout', [AuthController::class, 'logout']);
            Route::post('verify-email', [AuthController::class, 'verifyEmail']);
        });
        Route::get('verify-email', [AuthController::class, 'verifyEmailToken'])->name('verify-email')->withoutMiddleware('api');
//        Route::post('/password/send-email', [ResetPasswordController::class, 'sendResetLinkEmail']);
//        Route::get('/password/show-token', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
//        Route::post('/password/reset', [ResetPasswordController::class, 'reset']);
    });
    Route::prefix('profile')->middleware('auth:sanctum')->group(function (){
        Route::post('update', [ProfileController::class, 'update']);
        Route::post('update-password', [ProfileController::class, 'updatePassword']);
    });
    Route::prefix('favorites')->middleware('auth:sanctum')->group(function (){
        Route::get('index', [FavoriteController::class, 'index']);
        Route::get('toggle/{status}/{product}', [FavoriteController::class, 'toggle'])->where('status', 'add|remove');
    });
});
