<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HospitalControllers\Auth\AuthControllers;
use App\Http\Controllers\HospitalControllers\Auth\AdminController;
use App\Http\Controllers\HospitalControllers\Auth\CoordinatorController;
use App\Http\Controllers\HospitalControllers\Auth\StaffController;
use App\Http\Controllers\HospitalControllers\Auth\TesterController;


Route::prefix('/hospital')
    ->group(function () {
        Route::get('/get-detail-registration-service/{id}', [AuthControllers::class, 'getDetailRegistrationService']);

        Route::get('/get-registration', [AuthControllers::class, 'listRegistration']);
        Route::get('/get-detail-registration/{id}', [AuthControllers::class, 'detailRegistration']);
        Route::get('/fill-regis-by-type/{type}', [AuthControllers::class, 'fillRegisByType']);
        Route::get('/search-regis/{search}', [AuthControllers::class, 'searchRegis']);
        Route::get('/search-service/{search}', [AuthControllers::class, 'searchService']);

        Route::get('/cancel-registration/{id}', [AuthControllers::class, 'cancelRegis']);


        Route::prefix('/admin')->group(function () {
            Route::post('/create-user', [AdminController::class, 'createUser']);
            Route::post('/update-user', [AdminController::class, 'updateUser']);
            Route::get('/get-list-user', [AdminController::class, 'listUser']);
            Route::get('/get-user-detail/{id}', [AdminController::class, 'getUserDetail']);
            Route::get('/get-service-detail/{id}', [AdminController::class, 'getServiceDetail']);
            Route::get('/get-all-role', [AdminController::class, 'listRole']);
            Route::get('/fill-user-by-type/{id}', [AdminController::class, 'fillUserByType']);
            Route::get('/search-user/{search}', [AdminController::class, 'searchUser']);
            Route::post('/create-service', [AdminController::class, 'createService']);
            Route::post('/update-service', [AdminController::class, 'updateService']);
            Route::get('/statistics-now-year', [AdminController::class, 'statisticsNowYear']);
        });

        Route::prefix('/staff')->group(function () {
            Route::post('/create-registration-service', [StaffController::class, 'createRegistrationService']);
            Route::get('/get-all-regis-by-staff', [StaffController::class, 'getAllRegis']);
            Route::get('/refuseRegistration/{id}', [StaffController::class, 'refuseRegistration']);
        });

        Route::prefix('/tester')->group(function () {
            Route::get('/list-registration-service', [TesterController::class, 'listRegistrationService']);
            Route::post('/update-result-registration-service', [TesterController::class, 'updateResultRegistrationService']);
            Route::get('/get-detail-regis-service/{id}', [TesterController::class, 'detailRegistrationService']);
        });

        Route::prefix('/coordinator')->group(function () {
            Route::get('/get-all-staff', [CoordinatorController::class, 'listStaff']);
            Route::get('/all-regis-new', [CoordinatorController::class, 'listRegisNew']);
            Route::get('/refuse-registration/{id}', [CoordinatorController::class, 'refuseRegis']);
            Route::post('/assignment-registration', [CoordinatorController::class, 'assignmentRegistration']);
            Route::post('/update-registration', [CoordinatorController::class, 'updateRegistration']);
        });
    });