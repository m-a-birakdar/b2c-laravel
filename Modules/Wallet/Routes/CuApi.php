<?php

use Illuminate\Support\Facades\Route;
use Modules\Wallet\Http\Controllers\CuApi\V1\CardController;
use Modules\Wallet\Http\Controllers\CuApi\V1\TransactionController;
use Modules\Wallet\Http\Controllers\CuApi\V1\WalletController;

Route::prefix('v1/wallets')->middleware('auth:sanctum')->group(function (){
    Route::get('show', [WalletController::class, 'show']);
    Route::prefix('cards')->group(function (){
        Route::post('recharge', [CardController::class, 'recharge']);
    });
    Route::prefix('transactions')->group(function (){
        Route::get('index', [TransactionController::class, 'index']);
    });
});
