<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\BahanExport;
use App\Exports\ProduksiExport;
use App\Exports\ProductExport;
use App\Exports\PengeluaranExport;
use App\Exports\PenjualanExport;
use App\Exports\UpahExport;
use App\Exports\UtangExport;
use App\Exports\Order_produksiExport;

class ReportController extends Controller
{
    public function index()
    {
        $module           = [];
        $module['bahan']          = "Bahan";
        $module['produksi']       = "Produski";
        $module['product']        = "Product";
        $module['pengeluaran']    = "Pengeluaran";
        $module['penjualan']      = "Penjualan";
        $module['upah']           = "Upah";
        $module['utang']          = "Hutang";
        $module['order_produksi'] = "Order produksi";

        $data_view            = array();
        $data_view["title_h1"]               = "Data Report";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Report";
        $data_view["modal_title"]            = "Form Report";
        $data_view["card_title"]             = "Input & Update Data Report";
        $data_view["module"]                 = $module;


        return view('report/v_report', $data_view);
    }

    public function export(Request $request)
    {
        //print_r($request->all());die;
        if ($request->module == 'bahan') {
            return Excel::download(new BahanExport($request->all()), 'bahan.xlsx');
        } else if ($request->module == 'produksi') {
            return Excel::download(new ProduksiExport($request->all()), 'produksi.xlsx');
        } else if ($request->module == 'product') {
            return Excel::download(new ProductExport($request->all()), 'product.xlsx');
        } else if ($request->module == 'pengeluaran') {
            return Excel::download(new PengeluaranExport($request->all()), 'pengeluaran.xlsx');
        } else if ($request->module == 'penjualan') {
            return Excel::download(new PenjualanExport($request->all()), 'penjualan.xlsx');
        } else if ($request->module == 'upah') {
            return Excel::download(new UpahExport($request->all()), 'upah.xlsx');
        } else if ($request->module == 'utang') {
            return Excel::download(new UtangExport($request->all()), 'utang.xlsx');
        } else if ($request->module == 'order_produksi') {
            return Excel::download(new Order_produksiExport($request->all()), 'order_produksi.xlsx');
        }
        // return Excel::download(new BahanExport, 'bahan.xlsx');
    }
}
