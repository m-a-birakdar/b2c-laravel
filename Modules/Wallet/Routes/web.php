<?php

use Illuminate\Support\Facades\Route;
use Modules\Wallet\Http\Controllers\Web\WalletController;

Route::resource('wallets', WalletController::class);
