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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['web'])->prefix('/auth')->group(function () {
    Route::prefix('/google')->group(function () {
        Route::get('/redirect', [UserController::class, 'googleRedirect']);
        Route::get('/callback',[UserController::class, 'googleCallBack']);
    });
    Route::prefix('/facebook')->group(function () {
        Route::get('/redirect', [UserController::class, 'facebookRedirect']);
        Route::get('/callback',[UserController::class, 'facebookCallBack']);
    });
});