<?php

use App\Http\Controllers\Api;
use App\Http\Controllers\Api\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth/login', [Auth\TokensController::class, 'login']);
Route::post('auth/reset-password', [Auth\ResetPasswordRequest::class, 'resetRequest']);

Route::group(['middleware' => ['auth:sanctum', 'abilities:refresh']], function () {
    Route::post('auth/refresh', [Auth\TokensController::class, 'refresh']);
});

Route::group(['middleware' => ['auth:sanctum', 'abilities:access']], function () {
    Route::post('auth/logout', [Auth\TokensController::class, 'logout']);

    Route::get('user', [Api\UserController::class, 'user']);
});
