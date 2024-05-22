<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UpdateUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\EmailVerificationController;




Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/verify', [EmailVerificationController::class, 'verify']);
    Route::get('/user', [UpdateUserController::class, 'user']);
    Route::put('/update_user', [UpdateUserController::class, 'update_user']);
    // Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('http://localhost:5173/email-verified');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot_password']);
Route::post('/reset_password', [ForgotPasswordController::class, 'reset_password']);
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);
