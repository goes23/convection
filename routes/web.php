<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenjualanController;
use App\Product;

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
    Route::get('product/{id}/produksi', 'ProductController@get_data_produksi')->name('get.get_data_produksi');
    Route::get('product/{id}/variants', 'ProductController@get_data_variants')->name('get.get_data_variants');
    Route::get('product/{id}/history', 'ProductController@history')->name('get.history');
    Route::post('product/log_stock', 'ProductController@log_stock')->name('product.log_stock');
    Route::get('product/{id}/form', 'ProductController@form')->name('get.form');




    Route::resource('produksi', 'ProduksiController');
    Route::post('produksi/active', 'ProduksiController@active');
    Route::post('produksi/form', 'ProduksiController@form')->name('produksi.form');
    Route::get('produksi/{id}/form', 'ProduksiController@form')->name('get.form');


    Route::resource('channel', 'ChannelController');
    Route::post('channel/active', 'ChannelController@active');

    Route::resource('penjualan', 'PenjualanController');
    Route::post('penjualan/form', 'PenjualanController@form')->name('penjualan.form');
    Route::get('penjualan/{id}/form', 'PenjualanController@form')->name('get.form');
    Route::get('penjualan/{id}/detail', 'PenjualanController@detail')->name('penjualan.detail');
    Route::post('penjualan/get_data_product', 'PenjualanController@get_data_product')->name('penjualan.getdata');
    Route::post('penjualan/variant', 'PenjualanController@variant')->name('penjualan.variant');

    //Route::post('penjualan/form', 'PenjualanController@form')->name('penjualan.form');

    Route::resource('log_stock', 'LogStockController');
    Route::get('log_stock/{id}/get_sisa', 'LogStockController@get_sisa')->name('log_stock.get_sisa');

    Route::resource('upah', 'UpahController');
    Route::post('upah/bayar', 'UpahController@bayar')->name('upah.bayar');
    Route::get('upah/{id}/history', 'UpahController@history')->name('get.history');


    Route::resource('hutang', 'HutangController');

    Route::resource('pengeluaran', 'PengeluaranController');

    Route::resource('order_produksi', 'OrderProduksiController');
    Route::post('order_produksi/form', 'OrderProduksiController@form')->name('order_produksi.form');
    Route::get('order_produksi/{id}/form', 'OrderProduksiController@form')->name('get.form');
    Route::get('order_produksi/{id}/get_data', 'OrderProduksiController@get_data')->name('order_produksi.get_data');
});
