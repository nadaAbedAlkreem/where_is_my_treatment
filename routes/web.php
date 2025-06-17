<?php

use App\Http\Controllers\Dashboard\AnalyticsController;
use App\Http\Controllers\Dashboard\Auth\LoginController;
use App\Http\Controllers\Dashboard\PharmacyManagement\PharmacyStockController;
use App\Http\Controllers\Dashboard\RolesAndPermission\AdminController;
use App\Http\Controllers\Dashboard\RolesAndPermission\EmployeeController;
use App\Http\Controllers\Dashboard\RolesAndPermission\PermissionController;
use App\Http\Controllers\Dashboard\RolesAndPermission\PharmacyOwnerController;
use App\Http\Controllers\Dashboard\RolesAndPermission\RoleController;
use App\Http\Controllers\Dashboard\RolesAndPermission\UserController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\TreatmentManagement\CategoryController;
use App\Http\Controllers\Dashboard\TreatmentManagement\TreatmentController;
use Illuminate\Support\Facades\Route;


//pharmacies.store
Route::get('where-my-treatment-app', function () {
    return view('landing-page');
})->name('pharmacies.store');
Route::post('subscription-pharmacy-app', [PharmacyOwnerController::class, 'subscriptionPharmacyInApp'])->name('dashboard.pharmacy_owner.subscription');

Route::prefix('admin')->name('admin.')->group(function () {


    Route::middleware(['guest:admin'])->group(function () {
        Route::get('login', [LoginController::class, 'index'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('home', [AnalyticsController::class, 'index'])->name('dashboard.home');
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');

        Route::prefix('admins-management')->middleware(['auth:admin'])->group(function () {
            Route::get('', [AdminController::class, 'index'])->name('dashboard.admins');
            Route::delete('{adminId}', [AdminController::class, 'destroy'])->name('dashboard.admins.delete');
            Route::post('delete-multiple', [AdminController::class, 'deleteMultiple'])->name('dashboard.admins.deleteMultiple');
            Route::get('update-status/{adminId}/{status}', [AdminController::class, 'blockAdmin'])->name('dashboard.admins.block');
            Route::post('add', [AdminController::class, 'store'])->name('dashboard.admins.store');
            Route::post('update', [AdminController::class, 'edit'])->name('dashboard.admins.update');
            Route::post('update-password', [AdminController::class, 'updatePassword'])->name('dashboard.admins.update-passoword');
            Route::get('view', [AdminController::class, 'view'])->name('dashboard.admins.view');

        });

        Route::prefix('employee-management')->middleware(['auth:admin'])->group(function () {
            Route::get('', [EmployeeController::class, 'index'])->name('dashboard.employees');
            Route::delete('{employeeId}', [EmployeeController::class, 'destroy'])->name('dashboard.employees.delete');
            Route::post('delete-multiple', [EmployeeController::class, 'deleteMultiple'])->name('dashboard.employees.deleteMultiple');
            Route::get('update-status/{employeeId}/{status}', [EmployeeController::class, 'UpdateStatusEmployee'])->name('dashboard.employees.block');
            Route::post('add', [EmployeeController::class, 'store'])->name('dashboard.employees.store');
            Route::post('update', [EmployeeController::class, 'edit'])->name('dashboard.employees.update');
            Route::get('view', [EmployeeController::class, 'view'])->name('dashboard.employees.view');

        });
        Route::prefix('category-management')->middleware(['auth:admin'])->group(function () {
            Route::get('', [CategoryController::class, 'index'])->name('dashboard.category');
            Route::delete('{categoryId}', [CategoryController::class, 'destroy'])->name('dashboard.category.delete');
            Route::post('delete-multiple', [CategoryController::class, 'deleteMultiple'])->name('dashboard.category.deleteMultiple');
            Route::get('update-status/{categoryId}/{status}', [CategoryController::class, 'UpdateStatusEmployee'])->name('dashboard.category.block');
            Route::post('add', [CategoryController::class, 'store'])->name('dashboard.category.store');
            Route::post('update', [CategoryController::class, 'update'])->name('dashboard.category.update');
            Route::get('view', [CategoryController::class, 'view'])->name('dashboard.category.view');

        });
        Route::prefix('pharmacy-owner-management')->middleware(['auth:admin'])->group(function () {
            Route::get('', [PharmacyOwnerController::class, 'index'])->name('dashboard.pharmacy_owner');
            Route::delete('{pharmacyOwnerId}', [PharmacyOwnerController::class, 'destroy'])->name('dashboard.pharmacy_owner.delete');
            Route::post('delete-multiple', [PharmacyOwnerController::class, 'deleteMultiple'])->name('dashboard.pharmacy_owner.deleteMultiple');
            Route::get('update-status/{pharmacyOwnerId}/{status}', [PharmacyOwnerController::class, 'UpdateStatusPharmacyOwner'])->name('dashboard.pharmacy_owner.block');
            Route::get('update-status-approved/{pharmacyOwnerId}/{status}', [PharmacyOwnerController::class, 'UpdateStatusPharmacyApproved'])->name('dashboard.pharmacy_owner.approved');
            Route::post('add', [PharmacyOwnerController::class, 'store'])->name('dashboard.pharmacy_owner.store');
            Route::post('update', [PharmacyOwnerController::class, 'edit'])->name('dashboard.pharmacy_owner.update');
            Route::get('view', [PharmacyOwnerController::class, 'view'])->name('dashboard.pharmacy_owner.view');
            Route::post('update-location', [PharmacyOwnerController::class, 'updateLocationPharmacy'])->name('dashboard.pharmacy_owner.update.location');

        });

        Route::prefix('stock-pharmacy-management')->middleware(['auth:admin'])->group(function () {
            Route::get('', [PharmacyStockController::class, 'index'])->name('dashboard.stock_pharmacy');
            Route::delete('{pharmacyStockId}', [PharmacyStockController::class, 'destroy'])->name('dashboard.stock_pharmacy.delete');
            Route::post('delete-multiple', [PharmacyStockController::class, 'deleteMultiple'])->name('dashboard.stock_pharmacy.deleteMultiple');
             Route::post('add', [PharmacyStockController::class, 'store'])->name('dashboard.stock_pharmacy.store');
            Route::post('update', [PharmacyStockController::class, 'update'])->name('dashboard.stock_pharmacy.update');
            Route::get('view', [PharmacyStockController::class, 'view'])->name('dashboard.stock_pharmacy.view');
            Route::get('filter/treatment', [PharmacyStockController::class, 'filterTreatment'])->name('dashboard.stock_pharmacy.filter.treatment');
            Route::get('update-status/{pharmacyId}/{status}', [PharmacyStockController::class, 'UpdateStatus'])->name('dashboard.stock_pharmacy.status');

        });

        Route::prefix('treatment-management')->middleware(['auth:admin'])->group(function () {
            Route::get('', [TreatmentController::class, 'index'])->name('dashboard.treatment_management');
            Route::delete('{treatmentId}', [TreatmentController::class, 'destroy'])->name('dashboard.treatment_management.delete');
            Route::post('delete-multiple', [TreatmentController::class, 'deleteMultiple'])->name('dashboard.treatment_management.deleteMultiple');
            Route::get('update-status/{treatmentId}/{status}', [TreatmentController::class, 'UpdateStatusTreatment'])->name('dashboard.treatment_management.approve');
            Route::post('add', [TreatmentController::class, 'store'])->name('dashboard.treatment_management.store');
            Route::post('update', [TreatmentController::class, 'update'])->name('dashboard.treatment_management.update');
            Route::get('view', [TreatmentController::class, 'view'])->name('dashboard.treatment_management.view');

        });

        Route::prefix('users-management')->middleware(['auth:admin'])->group(function () {
            Route::get('', [UserController::class, 'index'])->name('dashboard.users-management.users');

        });
        Route::prefix('permission-roles-management')->middleware(['auth:admin'])->group(function () {
            Route::get('permissions', [PermissionController::class, 'index'])->name('dashboard.permission-roles-management.permission');
            Route::get('roles', [RoleController::class, 'index'])->name('dashboard.permission-roles-management.roles');
        });
        Route::get('permissions', [SettingController::class, 'index'])->name('dashboard.setting');


    });


});



