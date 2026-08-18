<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes - Dashboard Module
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // ----------------------------------------------------
    // Admin & Project Manager Only
    // ----------------------------------------------------
    Route::middleware('role:Admin,ProjectManager')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });

});