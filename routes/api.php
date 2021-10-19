<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('users/{status?}' , [UserController::class, 'viewUsers']);
Route::get('me' , [UserController::class, 'me'])->middleware('auth:api');
Route::get('verify/auth' , [UserController::class, 'verifyAuth'])->middleware('auth:api');
Route::PUT('verify/{id}/{status}' , [UserController::class, 'verifyUser']);
Route::PUT('{id}/approve' , [UserController::class, 'approveLogin']);
Route::POST('login' , [UserController::class, 'login']);

Route::middleware(['web'])->group(function () {
    Route::get('{provider}/redirect' , [UserController::class, 'redirect']);
    Route::get('{provider}/callback' , [UserController::class, 'callBack']);
});