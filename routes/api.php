<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControllers\Auth\AuthControllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
], function () {
    Route::post('/login', [AuthControllers::class, 'login']);
    Route::post('/patient-registration', [AuthControllers::class, 'patientRegistration']);
    Route::get('/logout', [AuthControllers::class, 'logout']);
    Route::get('/get-user', [AuthControllers::class, 'getUser']);
    Route::post('/refresh-token', [AuthControllers::class, 'refresh']);

    Route::get('/get-all-service', [AuthControllers::class, 'listService']);
    Route::get('/get-result-registration-service/{id}', [AuthControllers::class, 'getResultRegistrationService']);
    Route::post('/filter-listResult-regis-service', [AuthControllers::class, 'fillResultRegistrationService']);

    include ('hospitalApi.php');
    include ('userApi.php');
});
