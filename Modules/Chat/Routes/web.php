<?php

use Illuminate\Support\Facades\Route;
use Modules\Chat\Http\Controllers\Web\ChatController;

Route::prefix('chat')->middleware('auth')->name('chat.')->group(function () {
    Route::get('index', [ChatController::class, 'index'])->name('index');
});
