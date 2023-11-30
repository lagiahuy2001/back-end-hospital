<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControllers\Auth\AuthControllers;
use App\Http\Controllers\UserControllers\Auth\PatientController;

Route::prefix('app')
    ->group(function () {

        Route::post('/create-registration', [PatientController::class, 'createRegistration']);
        Route::get('/get-list-registration', [PatientController::class, 'patientGetListRegistration']);
        Route::get('/get-detail-registration/{id}', [PatientController::class, 'patientGetDetailRegistration']);

    });