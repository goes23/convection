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
        $data_bahan = Bahan::where('sisa_bahan', '<>', 0)
            ->select('id', 'kode', 'name')
            ->get();

        $data_product = Product::all();

        // $data_product = Product::where('status', 1)
        //     ->select('id', 'kode', 'name')
        //     ->get();

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
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('produksi/v_list', $data_view);
    }

    public function form(Request $request, $id = "")
    {

        if ($request->id == "") {
            $data_bahan = Bahan::where('sisa_bahan', '<>', 0)
                ->select('id', 'kode', 'name')
                ->get();

            $data_product = Product::all();

            $data_view                = [];
            $data_view['h1']                     = 'Form Produksi';
            $data_view['breadcrumb_item']        = 'Produksi List';
            $data_view['breadcrumb_item_active'] = 'Form Produksi';
            $data_view['card_title']             = 'Form Produksi';
            $data_view["bahan"]                  = $data_bahan;
            $data_view["product"]                = $data_product;
            $data_view['status']                 = 'add';
            return view('produksi/v_form', $data_view);
        } else {
            // $data_order = OrderHeader::with('order_item', 'channel')
            //     ->where('order_header.id', $id)
            //     ->get();

            $data_view                = [];
            $data_view['h1']                     = 'Form Produksi';
            $data_view['breadcrumb_item']        = 'Produksi List';
            $data_view['breadcrumb_item_active'] = 'Form Produksi';
            $data_view['card_title']             = 'Form Produksi';
            $data_view['channel']                = [];
            //dd($data_view['channel']);
            $data_view['product']                = [];
            $data_view['data_order']             = [];
            $data_view['status']                 = 'edit';
            return view('produksi/v_form', $data_view);
        }
    }


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
        if ($request["id"]) {
            $id = $request["id"];
            $jumlah = $request["data"]["jumlah"];
            if ($request["sisa"] == null) {
                $sisa = $request["data"]["jumlah"];
            } else {
                $sisa = $request["sisa"];
            }
        } else {
            $produksi = new Produksi();
            $data = $produksi->get_data_produksi($request["data"]["bahan"], $request["data"]["product"]);

            $id = "";
            $jumlah = 0;
            $sisa = 0;
            if ($data) {
                $id = $data[0]->id;
                $jumlah = (int) $data[0]->jumlah + (int) $request["data"]["jumlah"];

                if ($request["sisa"] == null) {
                    $sisa = (int) $request["data"]["jumlah"] + (int) $data[0]->sisa;
                } else {
                    $sisa = $request["sisa"] + (int) $data[0]->sisa;
                }
            } else {
                $id = $request["id"];
                $jumlah = $request["data"]["jumlah"];

                if ($request["sisa"] == null) {
                    $sisa = $request["data"]["jumlah"];
                } else {
                    $sisa = $request["sisa"];
                }
            }
        }

        $post = Produksi::UpdateOrCreate(["id" => $id], [
            'bahan_id' => $request["data"]["bahan"],
            'product_id' => $request["data"]["product"],
            'jumlah' => $jumlah,
            'sisa' => $sisa,
            'status' => $request["data"]["status"],
            'created_by' => session('user')

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
