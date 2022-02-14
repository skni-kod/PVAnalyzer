<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PVInstallationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PVInstallationCounterReadingController;

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
// Route::model('pv-installations', App\Models\PVInstallation::class);
// Route::model('counterReading', App\Models\CounterReading::class);


//Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //User
    Route::get('/users/{user}', [App\Http\Controllers\AuthController::class, 'showUser']);
    Route::put('/users/{user}', [App\Http\Controllers\AuthController::class, 'editProfile']);
    Route::put('/users/{user}/change-password', [App\Http\Controllers\AuthController::class, 'changePassword']);
    //PVInstallations
    Route::get('/pv-installations', [App\Http\Controllers\PVInstallationController::class, 'index']);
    Route::post('/pv-installations', [App\Http\Controllers\PVInstallationController::class, 'store']);
    Route::get('/pv-installations/{pVInstallation}', [App\Http\Controllers\PVInstallationController::class, 'show']);
    Route::put('/pv-installations/{pVInstallation}', [App\Http\Controllers\PVInstallationController::class, 'update']);
    Route::delete('/pv-installations/{pVInstallation}', [App\Http\Controllers\PVInstallationController::class, 'destroy']);
    //Counter Readings
    Route::apiResource('pv-installations.counter-readings', PVInstallationCounterReadingController::class)->parameters([
        'pv-installations' => 'pVInstallation',
        'counter-readings' => 'counterReading'
    ]);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
