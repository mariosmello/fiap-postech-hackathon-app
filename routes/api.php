<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::post('doctor/login', [AuthController::class, 'login_doctor']);
Route::post('patient/login', [AuthController::class, 'login_patient']);

Route::middleware(['auth:api', 'role:patient'])->group(function () {
    Route::post('users/create', [AuthController::class, 'store']);
});
