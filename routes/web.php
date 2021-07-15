<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelController;
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




Route::get('login', 'AuthController@index')->name('login');
Route::post('login', 'AuthController@login');
Route::post('remember', 'AuthController@remember')->name('remember');

Route::group(['middleware' => 'ceklogin'], function () {
    Route::get('/', 'DashboardController@index')->name('/');
    Route::get('logout', 'AuthController@logout')->name('logout');
});


Route::resource('bahan', 'BahanController');
Route::post('bahan/active', 'BahanController@active');

Route::resource('module', 'ModuleController');
Route::post('module/active', 'ModuleController@active');

Route::resource('product', 'ProductController');
Route::post('product/active', 'ProductController@active');

Route::resource('produksi', 'ProduksiController');
Route::post('produksi/active', 'ProduksiController@active');

Route::resource('channel', 'ChannelController');
Route::post('channel/active', 'ChannelController@active');


