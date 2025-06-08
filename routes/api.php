<?php

use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\SocialAuthController;
use App\Http\Controllers\Api\V1\Auth\UserController;
use App\Http\Controllers\Api\V1\TreatmentManagement\CategoryController;
use App\Http\Controllers\Api\V1\TreatmentManagement\PharmaciesController;
use App\Http\Controllers\Api\V1\TreatmentManagement\TreatmentController;
use App\Http\Controllers\Api\V1\TreatmentManagement\TreatmentSearchController;
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
                Route::post('update-location', [UserController::class, 'updateLocationUser']);
                Route::post('update-profile', [UserController::class, 'updateProfile']);
                Route::get('current-user', [UserController::class, 'getCurrentUser']);
                Route::delete('favorite-delete/{id}', [UserController::class, 'deleteFavoriteOFCurrentUser']);
                Route::get('delete-account-user/{id}', [UserController::class, 'deleteUser']);
                Route::post('store-rating', [UserController::class, 'storeRatingApp']);

            });
            Route::prefix('categories')->group(function ()
            {
                Route::get('', [CategoryController::class, 'getCategories']);
            });
            Route::prefix('pharmacies')->group(function ()
            {
                Route::get('pharmacies-nearest', [PharmaciesController::class, 'getPharmaciesNearestToCurrentUser']);
                Route::get('search-of-treatment-pharmacies-nearest', [PharmaciesController::class, 'searchTreatmentOnPharmaciesNearestToCurrentUser']);
                Route::get('search-treatment', [PharmaciesController::class, 'searchTreatmentsOnStock']);
                Route::get('favorite', [PharmaciesController::class, 'getFavoritesForCurrentUser']);
                Route::post('store-favorite', [PharmaciesController::class, 'storeFavouritePharmacies']);
                Route::post('store-rating', [PharmaciesController::class, 'storeRatingPharmacies']);

            });
            Route::prefix('treatments')->group(function ()
            {
                Route::get('search', [TreatmentController::class, 'searchTreatments']);
                Route::get('favorite', [TreatmentController::class, 'getFavoritesForCurrentUser']);
                Route::get('most-searched-treatment', [TreatmentController::class, 'getMostSearchedTreatments']);

                Route::post('store-request-treatment-available', [TreatmentController::class, 'storeTreatmentAvailabilityRequest']);
                Route::post('store-favorite', [TreatmentController::class, 'storeFavouriteTreatment']);
                Route::post('store-search-treatment', [TreatmentSearchController::class, 'createSearch']);
            });

        });

