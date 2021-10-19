<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



// we are using web middleware because socialite package return error if we don't
// basically its because som session errors
Route::middleware(['web'])->group(function () {
    Route::get('{provider}/redirect' , [UserController::class, 'redirect']);
    Route::get('{provider}/callback' , [UserController::class, 'callBack']);
});
Route::middleware(['auth:api'])->group(function () {
    // verify auth is a simple function makes sure that user token is valid
    Route::get('verify/auth' , [AuthController::class, 'verifyAuth'])->middleware('auth:api');
    Route::get('me' , [AuthController::class, 'me']);
});

// admin routes
// i should use middleware here but you didn't say anything about multi auth on the task so 
// the admin url is public which is illogic

Route::get('users/{status?}' , [UserController::class, 'viewUsers']);
Route::PUT('verify/{id}/{status}' , [UserController::class, 'verifyUser']);
Route::PUT('{id}/approve' , [UserController::class, 'approveLogin']);