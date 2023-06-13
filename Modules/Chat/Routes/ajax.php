<?php

use Illuminate\Support\Facades\Route;
use Modules\Chat\Http\Controllers\Ajax\ChatController;

Route::middleware('auth')->group(function (){
    Route::get('load-users', [ChatController::class, 'loadUsers'])->name('load-users');
    Route::get('messages', [ChatController::class, 'messages'])->name('messages');
});
