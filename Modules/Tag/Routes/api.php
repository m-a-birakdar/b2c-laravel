<?php

use Illuminate\Support\Facades\Route;
use Modules\Tag\Http\Controllers\Api\V1\TagController;

Route::prefix('v1')->group(function (){
    Route::apiResource('tags', TagController::class);
});
