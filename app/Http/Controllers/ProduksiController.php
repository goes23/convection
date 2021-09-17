<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produksi;
use App\Bahan;
use App\Product;
use App\Variants;
use Illuminate\Support\Facades\DB;

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

        // dd($request->all());
        // array:13 [
        //     "_token" => "imUiWQhkXpyGbBztmJmmCcvQvsjqUo9Yx4DcF3eL"
        //     "id" => null
        //     "kode_produksi" => null
        //     "product_id" => "1"
        //     "bahan_id" => "1"
        //     "bidang" => "123"
        //     "pemakaian" => "123"
        //     "harga_potong_satuan" => "11"
        //     "harga_jait_satuan" => "122"
        //     "harga_finishing_satuan" => "11"
        //     "harga_aksesoris" => "11"
        //     "harga_modal_bahan_satuan" => "123"
        //     "variants" => array:2 [
        //       0 => array:3 [
        //         "id" => null
        //         "size" => "M"
        //         "jumlah_produksi" => "10"
        //       ]
        //       1 => array:3 [
        //         "id" => null
        //         "size" => "XL"
        //         "jumlah_produksi" => "11"
        //       ]
        //     ]
        //   ]

        if ($request['id'] == null && $request['kode_produksi'] == null) {
            $kode = generate_kode();
        } else {
            $kode = $request['kode_produksi'];
            DB::select("DELETE FROM variants
            WHERE kode_produksi = $kode
            -- AND id NOT IN ($conditon)");
        }


        $data = [];
        $data['kode_produksi']            = $kode;
        $data['product_id']               = $request['product_id'];
        $data['bahan_id']                 = $request['bahan_id'];
        $data['bidang']                   = $request['bidang'];
        $data['pemakaian']                = $request['pemakaian'];
        $data['harga_potong_satuan']      = $request['harga_potong_satuan'];
        $data['harga_jait_satuan']        = $request['harga_jait_satuan'];
        $data['harga_finishing_satuan']   = $request['harga_finishing_satuan'];
        $data['harga_aksesoris']          = $request['harga_aksesoris'];
        $data['harga_modal_bahan_satuan'] = $request['harga_modal_bahan_satuan'];
        $data['created_by']               = session('user');

        try {
            DB::beginTransaction();

            $post = Produksi::UpdateOrCreate(["id" => $request['id']], $data);

            foreach ($request['variants'] as $val) {

                $variant['kode_produksi']        = $kode;
                $variant['product_id']           = $request['product_id'];
                $variant['size']                 = $val['size'];
                $variant['jumlah_produksi']      = $val['jumlah_produksi'];
                $variant['sisa_jumlah_produksi'] = 0;
                $variant['jumlah_stock_product'] = 0;

                Variants::insert($variant);
            }

            DB::commit();
            return response()->json($post);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json($e);
        }
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
