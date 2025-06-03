<?php

use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\SocialAuthController;
use App\Http\Controllers\Api\V1\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



        Route::prefix('auth')->group(function ()
        {
         //    Route::get('/users', [UserController::class, 'getAllUsers']);
        //    Route::get('/user/delete/{id}', [UserController::class, 'deleteUser']);
        //
        //    Route::get('/users/search', [UserController::class, 'getSearchUsers']);
            Route::post('/register', [RegisterController::class, 'register']);
            Route::post('/login', [LoginController::class, 'login'])->name('login-post');
            Route::post('social-callback', [SocialAuthController::class, 'handleSocialLogin']);
            Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
            Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);
            Route::post('verifyToken', [ForgotPasswordController::class, 'verifyToken']);

        });
        Route::middleware(['auth:sanctum'])->group(function ()
        {
            Route::post('/logout', [LoginController::class, 'logout']);

            Route::prefix('user')->group(function ()
            {
                Route::post('store-location', [UserController::class, 'storeLocationUser']);
                Route::post('profile/update', [UserController::class, 'updateProfile']);
            });

        });

