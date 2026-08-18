<?php

use Illuminate\Support\Facades\Route;
use Modules\ProjectManagement\App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes - Project Module
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
    // Full CRUD: index, store, show, update, destroy
    // ----------------------------------------------------
    Route::middleware('role:Admin,ProjectManager')->group(function () {
        Route::apiResource('projects', ProjectController::class);
    });

});