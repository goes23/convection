<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produksi;
use App\Bahan;
use App\Product;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.        $all_data = Module::all();
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd("po");
        $data_bahan = Bahan::where('status', 1)
            ->select('id', 'kode', 'name')
            ->get();

        $data_product = Product::where('status', 1)
            ->select('id', 'kode', 'name')
            ->get();

        $data_view            = array();
        $data_view["title_h1"]               = "Data Produksi";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Produksi";
        $data_view["modal_title"]            = "Form Produksi";
        $data_view["card_title"]             = "Input & Update Data Produksi";
        $data_view["bahan"]                  = $data_bahan;
        $data_view["product"]                = $data_product;

        if ($request->ajax()) {
            $list = Produksi::with('bahan', 'product')->get();
            return datatables()->of($list)
                ->addColumn('bahan', function ($data) {
                    $bahan = $data->bahan->kode . ' - ' . $data->bahan->name;
                    return $bahan;
                })
                ->rawColumns(['bahan'])
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
                    $button = '<center><button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('produksi/v_list', $data_view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $id = $request["id"];

        $post = Produksi::UpdateOrCreate(["id" => $id], [
            'bahan_id' => $request["data"]["bahan"],
            'product_id' => $request["data"]["product"],
            'jumlah' => $request["data"]["jumlah"],
            'sisa' => $request["data"]["jumlah"],
            'status' => $request["data"]["status"],
            'created_by' => 1

        ]);


        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $data = Produksi::where(["id" => $id])->first();

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        $delete = Produksi::find($id)->delete();

        return response()->json($delete);
    }

    public function active(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $update = Produksi::where(['id' => $request['id']])
            ->update(['status' => $request['data']]);

        return response()->json($update);
    }
}
