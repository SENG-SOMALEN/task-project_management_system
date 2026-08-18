<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\UserController;

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

Route::get('/force-migrate', function () {
    try {
        Artisan::call('migrate:fresh --force'); // ឬ Artisan::call('migrate --force');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        return response()->json([
            'status' => 'success',
            'message' => 'Database Migrated & Cache Cleared Successfully!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
