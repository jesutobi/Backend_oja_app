<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForgotPasswordController;




Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/verify', [EmailVerificationController::class, 'verify']);
    // Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('http://localhost:5173/email-verified');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot_password']);
Route::post('/reset_password', [ForgotPasswordController::class, 'reset_password']);
