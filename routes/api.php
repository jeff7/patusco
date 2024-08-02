<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;

Route::apiResource('appointment', AppointmentController::class);
Route::apiResource('user', UserController::class);
Route::post('/login', [LoginController::class, 'login']);

