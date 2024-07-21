<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('users/create', [AuthController::class, 'store']);
    Route::post('users/delete-request', [\App\Http\Controllers\DeleteRequestController::class, 'store']);
});
