<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\UserController;

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
Route::get('/ping', function(){
    return ['pong'=>true];
});

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::prefix('/auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});
Route::post('/user', [AuthController::class, 'store']);

Route::get('/user', [UserController::class, 'index']);
Route::put('/user', [UserController::class, 'update']);
Route::get('/user/favorites', [UserController::class, 'favorites']);
Route::post('/user/favorite', [UserController::class, 'store']);
Route::get('/user/appointments', [UserController::class, 'appointments']);

Route::get('/barbers', [BarberController::class, 'index']);
Route::get('/barber/{id}', [BarberController::class, 'show']);
Route::post('/barber/{id}/appointment', [BarberController::class, 'appointment']);

Route::get('/search', [BarberController::class, 'search']);
