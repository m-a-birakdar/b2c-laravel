<?php

use Illuminate\Support\Facades\Route;
use Modules\Tag\Http\Controllers\Web\TagController;

Route::resource('tags', TagController::class);
