<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\Backend;
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

Route::redirect('/', '/login');

// Auth
Route::get('/logout', [Auth\LoginController::class, 'logout'])->name('auth.logout');

Route::group(['middleware' => ['auth:web'], 'prefix' => '/backend'], function () {
    Route::get('/', [Backend\DashboardController::class, 'dashboard'])->name('backend.dashboard');
});
