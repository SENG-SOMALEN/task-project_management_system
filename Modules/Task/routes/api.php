<?php

use Illuminate\Support\Facades\Route;
use Modules\Task\App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes - Task Module
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // ================================================
    // 1. Admin & Project Manager Only
    // - Create, Full Update, Delete Task
    // - Assign Task, Change Priority, Set Due Date
    // ================================================
    Route::middleware('role:Admin,ProjectManager')->group(function () {

        // Specific Management Routes
        Route::put('tasks/{id}/assign', [TaskController::class, 'assign']);
        Route::put('tasks/{id}/priority', [TaskController::class, 'priority']);
        Route::put('tasks/{id}/due-date', [TaskController::class, 'dueDate']);

        // Task CRUD Actions (Store, Update, Destroy)
        Route::post('tasks', [TaskController::class, 'store']);
        Route::put('tasks/{id}', [TaskController::class, 'update']);
        Route::delete('tasks/{id}', [TaskController::class, 'destroy']);
    });

    // ================================================
    // 2. Shared Routes (Admin, ProjectManager, TeamMember)
    // - View Task List & Single Task
    // - Update Task Status (Pending, In Progress, Done)
    // ================================================
    Route::middleware('role:Admin,ProjectManager,TeamMember')->group(function () {

        // Read Tasks
        Route::get('tasks', [TaskController::class, 'index']);
        Route::get('tasks/{id}', [TaskController::class, 'show']);

        // Update Task Status (Team Member អាចដូរបានតែ Status)
        Route::put('tasks/{id}/status', [TaskController::class, 'status']);
    });

});