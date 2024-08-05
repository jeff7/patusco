<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('login');
});
Route::get('/home', function () {
    return view('auth/home');
});
