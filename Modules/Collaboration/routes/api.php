<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Collaboration\App\Http\Controllers\CommentController;
use Modules\Collaboration\App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes - Collaboration Module
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // ----------------------------------------------------
    // Shared Routes (Admin, ProjectManager, TeamMember)
    // ----------------------------------------------------
    Route::middleware('role:Admin,ProjectManager,TeamMember')->group(function () {

        // Comments Management
        Route::apiResource('comments', CommentController::class);

        // Notifications Management
        Route::get('notifications', [NotificationController::class, 'index']);
        Route::post('notifications', [NotificationController::class, 'store']);
        Route::get('notifications/{id}', [NotificationController::class, 'show']);
        Route::put('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::put('notifications/{id}/unread', [NotificationController::class, 'markAsUnread']);
        Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);
    });

});