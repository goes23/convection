<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderHeaderController;

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




Route::get('/', 'AuthController@index')->name('/login');
Route::get('login', 'AuthController@index')->name('login');
Route::post('login', 'AuthController@login');
Route::post('remember', 'AuthController@remember')->name('remember');

Route::group(['middleware' => ['ceklogin']], function () {
    // Route::get('admin-page', function() {
    //     return 'Halaman untuk Admin';
    // })->middleware('role:admin')->name('admin.page');
    Route::get('/dashboard', 'DashboardController@index')->name('/dashboard');
    Route::get('logout', 'AuthController@logout')->name('logout');
});

Route::group(['middleware' => ['ceklogin', 'checkpermission']], function () {

    Route::resource('role', 'RoleController');
    Route::post('role/active', 'RoleController@active');
    Route::post('role/datarole', 'RoleController@datarole')->name('role.datarole');
    Route::post('role/get_access', 'RoleController@get_access')->name('role.get_access');
    Route::post('role/add_role_access', 'RoleController@add_role_access')->name('role.add_role_access');
    Route::post('role/add_permission', 'RoleController@add_permission')->name('role.add_permission');

    Route::resource('user', 'UserController');
    Route::post('user/active', 'UserController@active');

    Route::resource('bahan', 'BahanController');
    Route::post('bahan/active', 'BahanController@active');

    Route::resource('module', 'ModuleController');
    Route::post('module/active', 'ModuleController@active');
    Route::post('module/dataparent', 'ModuleController@dataparent')->name('module.dataparent');
    Route::post('module/updatenorder', 'ModuleController@updatenorder')->name('module.updatenorder');

    Route::resource('product', 'ProductController');
    Route::post('product/active', 'ProductController@active');

    Route::resource('produksi', 'ProduksiController');
    Route::post('produksi/active', 'ProduksiController@active');
    Route::post('produksi/form', 'ProduksiController@form')->name('produksi.form');
    Route::get('produksi/{id}/form', 'ProduksiController@form')->name('get.form');


    Route::resource('channel', 'ChannelController');
    Route::post('channel/active', 'ChannelController@active');

    Route::resource('order_header', 'OrderHeaderController');
    Route::post('order_header/form', 'OrderHeaderController@form')->name('order_header.form');
    Route::get('order_header/{id}/form', 'OrderHeaderController@form')->name('get.form');
    Route::get('order_header/{id}/detail', 'OrderHeaderController@detail')->name('order_header.detail');
    //Route::post('order_header/form', 'OrderHeaderController@form')->name('order_header.form');

    Route::resource('log_stock', 'LogStockController');
    Route::get('log_stock/{id}/get_sisa', 'LogStockController@get_sisa')->name('log_stock.get_sisa');
});



