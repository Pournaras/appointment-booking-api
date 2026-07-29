<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/appointments', [AppointmentController::class, 'getAppointments']);
Route::post('/book', [AppointmentController::class, 'book']);
Route::post('/cancel', [AppointmentController::class, 'cancel']);
