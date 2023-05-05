<?php

use Illuminate\Support\Facades\Route;
use Modules\Wallet\Http\Controllers\Api\V1\WalletController;

Route::prefix('v1/wallets')->middleware('auth:sanctum')->group(function (){
    Route::get('show', [WalletController::class, 'show']);
    Route::apiResource('transactions', \Modules\Wallet\Http\Controllers\Api\V1\TransactionController::class)->only(['index', 'store']);
});
