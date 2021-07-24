<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logstock;
use App\Produksi;
use Illuminate\Support\Facades\DB;

class LogStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $log_stock = new Logstock();
        $data_poduksi = $log_stock->get_data_produksi();

        $data_view            = array();
        $data_view["title_h1"]               = "Data Log stock";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Log stock";
        $data_view["modal_title"]            = "Form Log stock";
        $data_view["card_title"]             = "Input & Update Data Log stock";
        $data_view['produksi']               = $data_poduksi;


        if ($request->ajax()) {
            return datatables()->of(Logstock::with('product')->get())
                ->addColumn('product', function ($data) {
                    $product = $data->product->kode . ' - ' . $data->product->name;
                    return $product;
                })
                ->rawColumns(['product'])
                ->addColumn('status', function ($data) {

                    if ($data->status == 1) {
                        $button = '<center><button type="button" class="btn btn-warning btn-sm" onclick="active(' . $data->id . ',0)"> Active </button> </center>';
                    } else {
                        $button = '<center><button type="button" class="btn btn-sm" style="background-color: #cccccc;" onclick="active(' . $data->id . ',1)"> Not Active </button> </center>';
                    }
                    return $button;
                })
                ->rawColumns(['status'])
                ->addColumn('action', function ($data) {
                    $button = '<center>';
                    if (allowed_access(session('user'), 'log_stock', 'edit')) :
                        $button = '<center><button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    endif;
                    $button .= '&nbsp;&nbsp;';
                    if (allowed_access(session('user'), 'log_stock', 'delete')) :
                        $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    endif;
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('log_stock/v_list', $data_view);
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $id_produksi = $request["produksi_id"];
        $id_product = $request["data"]["product"];

        try {
            DB::beginTransaction();
            $product = new Logstock();
            $update_stock_product = $product->update_stock_product($id_product, $request["data"]["qty"]);
            $update_sisa_produksi = $product->update_sisa_produksi($id_produksi, $request["data"]["qty"]);

            $id = $request["id"];

            $post = Logstock::UpdateOrCreate(["id" => $id], [
                'product_id' => $id_product,
                'qty' => $request["data"]["qty"],
                'transfer_date' => $request["data"]["transfer_date"],
                'created_by' => session('user')

            ]);

            DB::commit();
            return response()->json($post);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json($e);
        }
    }

    public function get_sisa(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $data = Produksi::where(["product_id" => $id])->get();

        return response()->json($data);
    }

    public function edit(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $data = Logstock::where(["id" => $id])->first();

        return response()->json($data);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        $delete = Logstock::find($id)->delete();

        return response()->json($delete);
    }
}
