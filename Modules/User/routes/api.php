<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\AuthController;
use Modules\User\App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes - User Module
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {

    // ----------------------------------------------------
    // 1. Authentication (Public Routes)
    // ----------------------------------------------------
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });

    // ----------------------------------------------------
    // 2. Authenticated Routes
    // ----------------------------------------------------
    Route::middleware('auth:sanctum')->group(function () {

        // Logout
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // ------------------------------------------------
        // Admin Only Routes
        // ------------------------------------------------
        Route::middleware('role:Admin')->group(function () {
            Route::apiResource('users', UserController::class);
        });

    });

    Route::get('/test-speed', function () {
        return response()->json([
            'message' => 'API is working',
        ]);
    });
});