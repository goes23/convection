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
                ->addColumn('action', function ($data) {
                    $button = '<center>';
                    if (allowed_access(session('user'), 'produksi', 'edit')) :
                        $button .= '<a type="button" href="/produksi/' . $data->id . '/form" class="btn btn-success btn-sm" >Edit</a>';
                    // $button = '<center><button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    endif;
                    $button .= '&nbsp;&nbsp;';
                    if (allowed_access(session('user'), 'produksi', 'delete')) :
                        $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    endif;
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('produksi/v_list', $data_view);
    }

    public function form(Request $request, $id = '')
    {
        $data_bahan = Bahan::where('sisa_bahan', '<>', 0)
            ->select('id', 'kode', 'name', 'panjang', 'sisa_bahan')
            ->get();

        $data_product = Product::all();

        $data_view                = [];
        $data_view['h1']                     = 'Form Produksi';
        $data_view['breadcrumb_item']        = 'Produksi List';
        $data_view['breadcrumb_item_active'] = 'Form Produksi';
        $data_view['card_title']             = 'Form Produksi';
        $data_view["bahan"]                  = $data_bahan;
        $data_view["product"]                = $data_product;
        // $data_view["size"]                   = $size;


        if ($id == "") {
            $data_view['status']                 = 0; // status add
            $data_view['data_produksi']          = [];
        } else {
            $data_produksi = Produksi::with('variants')
                ->where('produksi.id', $id)
                ->get();
            //dd($data_produksi);

            $data_view['data_produksi']          = $data_produksi;
            $data_view['status']                 = 1;  // status edit
        }
        return view('produksi/v_form', $data_view);
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
        //dd($_POST);
        $sisa_bahan = 0;
        // if ($request['status'] == 0) { // add

        if ($request['panjang_bahan'] > $request['sisa_bahan']) {
            $res = [
                'status_form' => $request['status'],
                'status' => false,
                'msg'   => 'Data request panjang bahan melebihi sisa bahan..!!'
            ];
            return response()->json($res);
        }
        $sisa_bahan = $request['sisa_bahan'] - $request['panjang_bahan'];
        // } else {

        //     if ($request['panjang_bahan'] > $request['panjang']) {
        //         $res = [
        //             'status_form' => $request['status'],
        //             'status' => false,
        //             'msg'   => 'Data request panjang bahan melebihi panjang bahan..!!'
        //         ];
        //         return response()->json($res);
        //     } else {
        //         $bahan_id = $request['bahan_id'];
        //         $id = $request['id'];

        //         $bahan = DB::select("SELECT panjang_bahan FROM produksi
        //                                 WHERE bahan_id = $bahan_id
        //                                 AND id != $id ");

        //         $jml = 0;
        //         foreach ($bahan as $val) {
        //             $jml += $val->panjang_bahan;
        //         }
        //         $sisa_bahan = ($request['panjang'] - $jml) - $request['panjang_bahan'];

        //         if($sisa_bahan < 0){
        //             $res = [
        //                 'status_form' => $request['status'],
        //                 'status' => false,
        //                 'msg'   => 'request melebihi panjang..!!'
        //             ];
        //             return response()->json($res);
        //         }

        //     }
        // }

        if ($request['id'] == null && $request['kode_produksi'] == null) {
            $kode = generate_kode();
        } else {
            $kode = $request['kode_produksi'];
        }

        $total_stock = 0;
        foreach ($request['variants'] as $vals) {
            $total_stock += $vals['jumlah_produksi'];
        }

        $data = array();
        $data['kode_produksi']            = $kode;
        $data['product_id']               = $request['product_id'];
        $data['bahan_id']                 = $request['bahan_id'];
        $data['panjang_bahan']            = $request['panjang_bahan'];
        $data['bidang']                   = $request['bidang'];
        $data['total_stock']              = $total_stock;
        $data['pemakaian']                = $request['pemakaian'];
        $data['harga_potong_satuan']      =  str_replace(".", "", $request['harga_potong_satuan']);
        $data['harga_jait_satuan']        =  str_replace(".", "", $request['harga_jait_satuan']);
        $data['harga_finishing_satuan']   =  str_replace(".", "", $request['harga_finishing_satuan']);
        $data['harga_aksesoris']          =  str_replace(".", "", $request['harga_aksesoris']);
        $data['harga_modal_bahan_satuan'] =  str_replace(".", "", $request['harga_modal_bahan_satuan']);
        $data['created_by']               = session('user');

        try {
            DB::beginTransaction();

            if ($request['id'] != null && $request['kode_produksi'] != null) {
                $id = $request['id'];
                DB::select("DELETE FROM variants
                WHERE produksi_id = $id");
            }

            $post = Produksi::UpdateOrCreate(["id" => $request['id']], $data);

            foreach ($request['variants'] as $val) {
                $jumlah_product = isset($val['jumlah_stock_product']) ? $val['jumlah_stock_product'] : null;
                $variant['kode_produksi']        = $kode;
                $variant['produksi_id']          = $post->id;
                $variant['product_id']           = $request['product_id'];
                $variant['size']                 = $val['size'];
                $variant['jumlah_produksi']      = $val['jumlah_produksi'];
                $variant['sisa_jumlah_produksi'] = $val['sisa_jumlah_produksi'];
                $variant['jumlah_stock_product'] = $jumlah_product;

                Variants::UpdateOrCreate(["id" => $val['id']], $variant);
            }

            $sisa_bahan = $request['sisa_bahan'] - $request['panjang_bahan'];
            Bahan::where(['id' => $request['bahan_id']])
                ->update(['sisa_bahan' => $sisa_bahan]);


            DB::commit();
            $res = [
                // 'status_form' => $request['status'],
                'status' => true,
                // 'msg'   => 'Data request panjang bahan melebihi panjang bahan..!!'
            ];
            return response()->json($res);
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

        try {
            DB::beginTransaction();

            $delete = Produksi::where('id', $id)->delete();
            variants::where('produksi_id', $id)->delete();

            DB::commit();

            return response()->json($delete);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json($e);
        }


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
