<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Channel;
use App\ItemPenjualan;
use App\Pengeluaran;
use App\Product;
use App\Variants;
use Illuminate\Support\Facades\DB;
use stdClass;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_view            = array();
        $data_view["title_h1"]               = "Data Penjualan";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Penjualan";
        $data_view["modal_title"]            = "Form Penjualan";
        $data_view["card_title"]             = "Input & Update Data Penjualan";

        if ($request->ajax()) {
            return datatables()->of(Penjualan::with('channel')->get())
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
                    $button .= '<button type="button" class="btn btn-secondary btn-sm" onClick="detail(' . $data->id . ')">Detail</button>';
                    $button .= '&nbsp;';
                    if (allowed_access(session('user'), 'penjualan', 'edit')) :
                        //$button .='<a href="" class="btn btn-xs btn-info pull-right">Edit</a>';
                        $button .= '<a type="button" href="/penjualan/' . $data->id . '/form" class="btn btn-success btn-sm" >Edit</a>';
                    endif;
                    $button .= '&nbsp;';
                    if (allowed_access(session('user'), 'penjualan', 'delete')) :
                        $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    endif;
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('penjualan/v_list', $data_view);
    }

    public function form(Request $request, $id = "")
    {

        $penjualan = new Penjualan();
        $data_product = $penjualan->get_data_products();
        //dd($data_product);

        if ($request->id == "") {
            $data_view                = [];
            $data_view['h1']                     = 'Form Penjualan';
            $data_view['breadcrumb_item']        = 'Penjualan List';
            $data_view['breadcrumb_item_active'] = 'Form Penjualan';
            $data_view['card_title']             = 'Form Order';
            $data_view['channel']                = Channel::all();
            $data_view['product']                = $data_product;
            $data_view['data_order']             = [];
            $data_view['status']                 = 0; //add
        } else {
            $penjualan = new Penjualan();
            $data_order = $penjualan->get_data_order($id);
            $item = new Penjualan();
            $data_item = $item->get_data_item($id);

            $dataitem = [];
            foreach ($data_item as $key => $val) {
                $dataitem[$val->product_id]['penjualan_id']                   = $val->penjualan_id;
                $dataitem[$val->product_id]['purchase_code']                  = $val->purchase_code;
                $dataitem[$val->product_id]['product_id']                     = $val->product_id;
                $dataitem[$val->product_id]['harga_jual']                     = $val->harga_jual;
                $dataitem[$val->product_id]['variant'][$key]['id']            = $val->id;
                $dataitem[$val->product_id]['variant'][$key]['size']          = $val->size;
                $dataitem[$val->product_id]['variant'][$key]['stock_product'] = $val->stock_product;
                $dataitem[$val->product_id]['variant'][$key]['sell_price']    = $val->sell_price;
                $dataitem[$val->product_id]['variant'][$key]['qty']           = $val->qty;
                $dataitem[$val->product_id]['variant'][$key]['keterangan']    = $val->keterangan;
            }

            // dd($dataitem);
            $data_view                = [];
            $data_view['h1']                     = 'Edit Form Penjualan';
            $data_view['breadcrumb_item']        = 'Edit Penjualan List';
            $data_view['breadcrumb_item_active'] = 'Edit Form Penjualan';
            $data_view['card_title']             = 'Edit Form Order';
            $data_view['channel']                = Channel::all();
            $data_view['product']                = $data_product;
            $data_view['data_order']             = $data_order;
            $data_view['item']                   = $dataitem;
            $data_view['status']                 = 1;                      // edit
        }

        return view('penjualan/v_form', $data_view);
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        if ($request['purchase_code'] != "" && $request['id'] != "") {
            $purchase_code = $request['purchase_code'];
        } else {
            $purchase_code = generate_purchase_code();
        }

        if ($request['purchase_code'] != "" && $request['id'] != "") {
            try {
                DB::beginTransaction();
                $post = Penjualan::UpdateOrCreate(["id" => $request['id'], "purchase_code" => $purchase_code], [
                    'purchase_code'    => $purchase_code,
                    'kode_pesanan'     => $request['kode_pesanan'],
                    'customer_name'    => $request['customer_name'],
                    'customer_phone'   => $request['customer_phone'],
                    'customer_address' => $request['customer_address'],
                    'channel_id'       => $request['channel'],
                    'purchase_date'    => $request['purchase_date'],
                    'total_purchase'   => 1,
                    'shipping_price'   => $request['shipping_price'],
                    'status'           => 1
                ]);


                foreach ($request['orderitem'] as $val) {
                    foreach ($val['variant'] as $vl) {
                        $price = str_replace(".", "", $vl['sell_price']);
                        $total = (int) $vl['qty'] * (int) $price;

                        ItemPenjualan::UpdateOrCreate(['id' => $vl['id']], [
                            'purchase_code' => $post->purchase_code,
                            'penjualan_id'  => $post->id,
                            'product_id'    => $vl['product'],
                            'sell_price'    => str_replace(".", "", $vl['sell_price']),
                            'qty'           => $vl['qty'],
                            'size'          => $vl['size'],
                            'total'         => $total,
                            'keterangan'    => $vl['keterangan']
                        ]);
                    }
                }
                DB::commit();
                return response()->json($post);
                exit;
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json($e);
            }
        } else {
            //dd($request->all());
            $update_va = [];
            foreach ($request['orderitem'] as $varian) {
                $sisa_kurang = 0;
                foreach ($varian['variant'] as $val) {
                    if ($val['qty_product'] < $val['qty']) {
                        $res = [
                            "status" => false,
                            "msg" => "qty input lebih besar dari stock product"
                        ];
                        return response()->json($res);
                        exit;
                    }
                    //dd($val);
                    $data_v = Variants::where('size', $val['size'])
                        ->where('product_id', $varian['product'])
                        ->where('jumlah_stock_product', '>', 0)
                        ->orderBy('created_at', 'asc')
                        ->get();

                    //dd($data_v);
                    foreach ($data_v as $key => $itm) {
                        if ($key == 0) {
                            $sisa_kurang =  $itm->jumlah_stock_product - $val['qty'];
                            $sisa = $sisa_kurang < 0 ? 0 : $sisa_kurang;
                            $sisa_kurang =  abs($sisa_kurang);
                        } else {
                            $sisa_kurang =  $itm->jumlah_stock_product - $sisa_kurang;
                            $sisa = $sisa_kurang < 0 ? 0 : $sisa_kurang;
                            $sisa_kurang =  abs($sisa_kurang);
                        }

                        $update_va[$itm->id]['id']          = $itm->id;
                        $update_va[$itm->id]['product_id']  = $itm->product_id;
                        $update_va[$itm->id]['size']        = $itm->size;
                        $update_va[$itm->id]['produksi_id'] = $itm->produksi_id;
                        $update_va[$itm->id]['sisa']        = $sisa;
                        if ($sisa > 0) {
                            break;
                        }
                    }
                }
            }

            foreach ($update_va as $vls) {

                $updates = [];
                $updates["jumlah_stock_product"] = $vls['sisa'];

                $update = Variants::where(['id' => $vls['id']])
                    ->update($updates);
            }

            try {
                DB::beginTransaction();

                $post = Penjualan::UpdateOrCreate(["id" => $request['id'], "purchase_code" => $purchase_code], [
                    'purchase_code'    => $purchase_code,
                    'kode_pesanan'     => $request['kode_pesanan'],
                    'customer_name'    => $request['customer_name'],
                    'customer_phone'   => $request['customer_phone'],
                    'customer_address' => $request['customer_address'],
                    'channel_id'       => $request['channel'],
                    'purchase_date'    => $request['purchase_date'],
                    'total_purchase'   => 1,
                    'shipping_price'   => $request['shipping_price'],
                    'status'           => 1
                ]);

                if ($request['purchase_code'] != "" && $request['id'] != "") :
                    $concat = '';
                    foreach ($request['orderitem'] as $del) {
                        $concat .= "'" . $del['id'] . "',";
                    }
                    $conditon = trim($concat, ",");
                    $ids = $request['id'];
                    DB::select("DELETE FROM item_penjualan
                    WHERE penjualan_id = $ids
                    AND id NOT IN ($conditon)");
                endif;
                // dd($request->all());

                foreach ($request['orderitem'] as $val) {
                    foreach ($val['variant'] as $vl) {
                        $price = str_replace(".", "", $vl['sell_price']);
                        $total = (int) $vl['qty'] * (int) $price;

                        ItemPenjualan::UpdateOrCreate(['id' => $val['id']], [
                            'purchase_code' => $post->purchase_code,
                            'penjualan_id'  => $post->id,
                            'product_id'    => $val['product'],
                            'sell_price'    => str_replace(".", "", $vl['sell_price']),
                            'qty'           => $vl['qty'],
                            'size'          => $vl['size'],
                            'total'         => $total,
                            'keterangan'    => $vl['keterangan']
                        ]);
                    }
                }

                DB::commit();

                return response()->json($post);
                exit;
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json($e);
            }
        }
    }

    public function edit(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $data = Penjualan::where(["id" => $id])->first();

        return response()->json($data);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        try {
            DB::beginTransaction();
            $delete = Penjualan::find($id)->delete();

            ItemPenjualan::where('penjualan_id', $id)->delete();

            DB::commit();

            return response()->json($delete);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json($e);
        }
    }


    public function detail(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $penjualan = new Penjualan();
        $detail = $penjualan->detail($id);
        // dd($detail);
        //$data['data_header'] = Penjualan::where('id', $id)->first();
        $data['data_detail'] = $detail;
        //dd($data['data_header']->id);

        return response()->json($data);
    }

    public function get_data_product(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $penjualan = new Penjualan();
        $data_variant = $penjualan->get_data_variant($request['id']);

        return response()->json($data_variant);
    }


    public function variant(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $penjualan = new Penjualan();
        $data_variant = $penjualan->jumlah_stock_product($request->all());

        return response()->json($data_variant[0]);
    }
}
