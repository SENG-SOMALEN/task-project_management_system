<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Team\App\Http\Controllers\TeamController;

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

Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {

        // ================================================
        // Team Read - All Roles
        // ================================================
        Route::middleware('role:Admin,ProjectM,TM')->group(function () {
            Route::get('teams', [TeamController::class, 'index']);
            Route::get('teams/{id}', [TeamController::class, 'show']);
        });

        // ================================================
        // Team Management - Admin & Project Manager
        // ================================================
        Route::middleware('role:Admin,ProjectM')->group(function () {
            Route::post('teams', [TeamController::class, 'store']);
            Route::put('teams/{id}', [TeamController::class, 'update']);
            Route::delete('teams/{id}', [TeamController::class, 'destroy']);
        });
    });
