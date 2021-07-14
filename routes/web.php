<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\BahanController;

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



Route::get('/', [DashboardController::class, 'index']);

Route::resource('bahan', 'BahanController');
Route::post('bahan/active', [BahanController::class, 'active']);

Route::resource('module', 'ModuleController');
Route::post('module/active', [ModuleController::class, 'active']);

// Route::prefix('role')->group(function () {
//     Route::get('/', [RoleController::class, 'index']);
//     Route::get('/list', [RoleController::class, 'list']);
//     Route::get('/create', [RoleController::class, 'create']);
//     Route::get('/edit', [RoleController::class, 'edit']);
//     Route::get('/destroy', [RoleController::class, 'destroy']);
// });
