<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\CuApi\V1\AuthController;
use Modules\User\Http\Controllers\CuApi\V1\ResetPasswordController;

Route::prefix('v1/auth')->group(function (){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/password/send-email', [ResetPasswordController::class, 'sendResetLinkEmail']);
    Route::get('/password/show-token', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset']);

});
