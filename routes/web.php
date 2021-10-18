<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return "asd";
});


Route::middleware(['guest'])->prefix('auth')->group(function () {
    Route::view('/' , 'auth');
    Route::view('/pending' , 'pending');
    Route::get('{provider}/redirect' , [UserController::class, 'redirect']);
    Route::get('{provider}/callback' , [UserController::class, 'callBack']);
});


Route::middleware(['auth'])->prefix('auth')->group(function () {
    Route::view('/user' , 'user');
});

Route::get('/privacy', function () {
    return view('privacy');
});
Route::get('/terms', function () {
    return view('privacy');
});
