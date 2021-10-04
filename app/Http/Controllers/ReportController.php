<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {

        // $report = new Report();
        // $data = $report->get_module();
        $module = [
            "Bahan","Product","Produksi"
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
}
