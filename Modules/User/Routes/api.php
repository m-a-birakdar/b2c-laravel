<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\V1\AuthController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware(['api', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class])->group(function () {
    Route::prefix('v1/auth')->group(function (){
        Route::get('login', [AuthController::class, 'login']);
        Route::get('register', [AuthController::class, 'register']);
    });
});
