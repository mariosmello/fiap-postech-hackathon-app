<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicalSpecialtyController;
use App\Http\Controllers\UserAvailabilityController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentPatientController;

Route::post('doctor/login', [AuthController::class, 'login_doctor']);
Route::post('patient/login', [AuthController::class, 'login_patient']);

Route::middleware(['auth:api', 'role:doctor|patient'])->group(function () {
    Route::apiResource('medical-specialties', MedicalSpecialtyController::class);
});

Route::middleware(['auth:api', 'role:doctor'])->prefix('doctor')->group(function () {
    Route::apiResource('user-availabilities', UserAvailabilityController::class);
    Route::put('appointments/{appointment}/confirm', [AppointmentController::class, 'confirm']);
    Route::put('appointments/{appointment}/decline', [AppointmentController::class, 'decline']);
});

Route::middleware(['auth:api', 'role:patient'])->prefix('patient')->group(function () {
    Route::get('doctors', [DoctorController::class, 'index']);
    Route::get('doctors/{user}/availabilities', [AppointmentController::class, 'index']);
    Route::post('doctors/{user}/availabilities/{user_availability}', [AppointmentController::class, 'store']);
    Route::get('appointments', [AppointmentPatientController::class, 'index']);
    Route::put('appointments/{appointment}/cancel', [AppointmentPatientController::class, 'cancel']);
});
