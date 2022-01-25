<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PVInstallationController;
use App\Http\Controllers\AuthController;

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

//Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/pv-installation/{id}', [App\Http\Controllers\PVInstallationController::class, 'show']);


//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function()
{
    Route::post('/pv-installation', [App\Http\Controllers\PVInstallationController::class, 'store']);
    Route::put('/pv-installation/{id}', [App\Http\Controllers\PVInstallationController::class, 'update']);
    Route::delete('/pv-installation/{id}', [App\Http\Controllers\PVInstallationController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
