<?php

use Illuminate\Support\Facades\Route;
use Modules\TeamMember\App\Http\Controllers\TeamMemberController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::resource('teammember', TeamMemberController::class)->names('teammember');
});
