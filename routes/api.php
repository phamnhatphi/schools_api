<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->middleware('auth:sanctum')->name('logout');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/me', [UserController::class, 'infoUserLogged']);
    Route::controller(ClassController::class)->prefix('class')->group(function() {
        Route::get('/list', 'index')->name('class-list');
        Route::get('/{id}', 'show')->name('class-detail');
        Route::put('/{id}', 'update')->name('class-update');
        Route::delete('/{id}', 'destroy')->name('class-destroy');
    });
});
