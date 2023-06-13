<?php

use Illuminate\Support\Facades\Route;
use Modules\Whatsapp\Http\Controllers\Web\WhatsappController;

Route::prefix('whatsapp')->middleware('auth')->name('whatsapp.')->group(function () {
    Route::get('show', [WhatsappController::class, 'show'])->name('show');
});
