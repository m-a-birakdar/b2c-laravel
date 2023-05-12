<?php

use Illuminate\Support\Facades\Route;
use Modules\Wallet\Http\Controllers\CuApi\V1\TransactionController;
use Modules\Wallet\Http\Controllers\CuApi\V1\WalletController;

Route::prefix('v1/wallets')->middleware('auth:sanctum')->group(function (){
    Route::get('show', [WalletController::class, 'show']);
    Route::apiResource('transactions', TransactionController::class)->only(['index', 'store']);
});
