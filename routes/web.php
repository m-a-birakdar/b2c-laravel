<?php

use App\Events\SendMessage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    event(new SendMessage());
    return view('welcome');
});
Route::get('/drag', function () {
    event(new SendMessage());
    return view('drag');
});
Route::get('/whatsapp', function () {
    return view('whatsapp');
});

Route::post('/drag', function (\Illuminate\Http\Request $request){
    $request->dd();
});

