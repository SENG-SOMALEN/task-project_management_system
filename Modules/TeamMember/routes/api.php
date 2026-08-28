<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

use Modules\TeamMember\App\Http\Controllers\TeamMemberController;

Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {

        // View all team members
        Route::get(
            'team-members',
            [TeamMemberController::class, 'index']
        );

        // View members of a specific team
        Route::get(
            'teams/{teamId}/members',
            [TeamMemberController::class, 'members']
        );

        // Add member to a team
        Route::post(
            'teams/{teamId}/members',
            [TeamMemberController::class, 'store']
        );

        // View specific team member
        Route::get(
            'team-members/{id}',
            [TeamMemberController::class, 'show']
        );

        // Remove member from team
        Route::delete(
            'team-members/{id}',
            [TeamMemberController::class, 'destroy']
        );
    });
