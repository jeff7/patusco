<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;


Route::apiResource('user', UserController::class);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['jwt.auth'])->group(function () {
  Route::get('/doctors', [UserController::class, 'getUserDoctors'])->name('user.getDoctors');;
  Route::get('/appointment', [AppointmentController::class, 'index']);
  Route::get('/appointment/{id}', [AppointmentController::class, 'show']);
  Route::put('/appointment/{id}', [AppointmentController::class, 'update']);
  Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy']);
  Route::post('/appointment', [AppointmentController::class, 'store']);
});


