<?php

namespace App\Http\Controllers;

use App\Produksi;
use Illuminate\Http\Request;
use App\Upah;

class UpahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_view            = array();
        $data_view["title_h1"]               = "Data Upah";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Upah";
        $data_view["modal_title"]            = "Form Upah";
        $data_view["card_title"]             = "Input & Update Data Upah";
        $data_view["produksi"]             = Produksi::all();

        if ($request->ajax()) {
            return datatables()->of(Upah::all())
                ->rawColumns(['status'])
                ->addColumn('action', function ($data) {
                    $button = '<center>';
                    if (allowed_access(session('user'), 'upah', 'edit')) :
                        $button = '<center><button type="button" class="btn btn-info btn-sm" onclick="edit(' . $data->id . ')">History Pembayaran</button>';
                        $button .= '&nbsp;';
                        $button .= '<button type="button" class="btn btn-warning btn-sm" onclick="edit(' . $data->id . ')">Pembayaran</button>';
                        $button .= '&nbsp;';
                        $button .= '<button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    endif;
                    $button .= '&nbsp;';
                    if (allowed_access(session('user'), 'upah', 'delete')) :
                        $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    endif;
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('upah/v_list', $data_view);
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        dd($request->all());

        $post = Upah::UpdateOrCreate(["id" => $request['id']], [
            'produksi_id' => $request["kode_produksi"],
            'total_upah' => str_replace(".", "", $request["total_upah"]),
            'sisa_upah' => str_replace(".", "", $request["total_upah"]),
            'date_transaksi' => $request["date_transaksi"]
        ]);
        if ($post) {
            $res = [
                "status" => true,
                "msg" => "success"
            ];
        } else {
            $res = [
                "status" => false,
                "msg" => "error add.."
            ];
        }

        return response()->json($res);
        exit;
    }

    public function edit(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $data = Upah::where(["id" => $id])->first();

        return response()->json($data);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        $delete = Upah::find($id)->delete();
        return response()->json($delete);
    }
}
