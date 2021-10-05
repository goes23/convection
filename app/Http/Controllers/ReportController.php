<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use App\Exports\BahanExport;

class ReportController extends Controller
{
    public function index()
    {
        $module = [
            "Bahan", "Product", "Produksi"
        ];

        $data_view            = array();
        $data_view["title_h1"]               = "Data Report";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Report";
        $data_view["modal_title"]            = "Form Report";
        $data_view["card_title"]             = "Input & Update Data Report";
        $data_view["module"]                 = $module;


        return view('report/v_report', $data_view);
    }

    public function get_repot(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $start = new DateTime($request['start']);
        $end = new DateTime($request['end']);
        $diff = date_diff($start, $end);
        if ($diff->d > 15) {
        }

        $report = new Report();
        $data = $report->get_report($request->all());

        $data_view = [];
        if (strtolower($request['report']) == 'bahan') {
            $data_view['head'] = [
                'Kode', 'Name', 'Harga', 'Tanggal beli', 'Satuan', 'Panjang', 'Sisa_bahan', 'Harga_satuan', 'Discount',
            ];
        } elseif (strtolower($request['report']) == 'product') {
        } elseif (strtolower($request['report']) == 'produksi') {
        }

        $data_view['table'] = $request['report'];
        $data_view['tbody'] = $data;

        $html = view('report/content', $data_view)->render();

        return response()->json(array('html' => $html));
    }

    public function create()
    {
        return Excel::download(new BahanExport, 'bahan.xlsx');
    }
}
