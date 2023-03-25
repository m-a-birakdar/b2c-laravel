<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'easy-build::auth.login')->name('login');
Route::view('/register', 'easy-build::auth.register')->name('register');
Route::view('/forget-password', 'easy-build::auth.forget-password')->name('forget-password');
Route::view('/recover-password', 'easy-build::auth.recover-password')->name('recover-password');
Route::view('/dashboard', 'easy-build::dashboard')->name('dashboard');
