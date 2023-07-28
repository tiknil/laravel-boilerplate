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
    Route::get('/toast-demo', [Backend\DashboardController::class, 'toastDemo'])->name('backend.toast-demo');
    Route::get('/alert-demo', [Backend\DashboardController::class, 'alertDemo'])->name('backend.alert-demo');

    Route::get('/profile', [Backend\ProfileController::class, 'page'])->name('backend.profile');
    Route::post('/profile', [Backend\ProfileController::class, 'submit'])->name('backend.profile.submit');

    Route::get('/users', [Backend\UsersController::class, 'page'])->name('backend.users');
    Route::get('/users/create', [Backend\UsersController::class, 'create'])->name('backend.users.create');
    Route::post('/users/create', [Backend\UsersController::class, 'store'])->name('backend.users.store');
    Route::get('/users/{id}/edit', [Backend\UsersController::class, 'edit'])->name('backend.users.edit');
    Route::patch('/users/{id}', [Backend\UsersController::class, 'update'])->name('backend.users.update');

    Route::view('/vue', 'backend.pages.vue')->name('backend.vue');

});
