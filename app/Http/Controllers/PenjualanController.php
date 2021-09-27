<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Channel;
use App\ItemPenjualan;
use App\Product;
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

        //dd(Penjualan::with('channel')->get());

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
        $data_product = $penjualan->get_data_product();


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
            return view('penjualan/v_form', $data_view);
        } else {
            $data_order = Penjualan::with('order_item', 'channel')
                ->where('penjualan.id', $id)
                ->get();

            $data_view                = [];
            $data_view['h1']                     = 'Edit Form Penjualan';
            $data_view['breadcrumb_item']        = 'Edit Penjualan List';
            $data_view['breadcrumb_item_active'] = 'Edit Form Penjualan';
            $data_view['card_title']             = 'Edit Form Order';
            $data_view['channel']                = Channel::all();
            //dd($data_view['channel']);
            $data_view['product']                = [];
            // $data_view['product']                = Product::where('stock', '!=', 0)->get();
            $data_view['data_order']             = $data_order;
            $data_view['status']                 = 1; // edit
            return view('penjualan/v_form', $data_view);
        }
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        foreach ($request['orderitem'] as $value) {
            if ($value['qty_product'] < $value['qty']) {
                $res = [
                    "status" => false,
                    "msg" => "pastikan input qty tidak 0 dan tidak boleh lebih besar dari qty product ..!!"
                ];
                return response()->json($res);
            }
        }
        dd($request->all());

        if ($request->purchase_code != "" && $request->id != "") {
            $purchase_code = $request->purchase_code;
        } else {
            $purchase_code = generate_purchase_code();
        }
        try {
            DB::beginTransaction();

            $post = Penjualan::UpdateOrCreate(["id" => $request->id, "purchase_code" => $purchase_code], [
                'purchase_code' => $purchase_code,
                'kode_pesanan' => $request->kode_pesanan,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'channel_id' => $request->channel,
                'purchase_date' => $request->purchase_date,
                'total_purchase' => 1,
                'shipping_price' =>  $request->shipping_price,
                'status' => 1
            ]);

            if ($request->purchase_code != "" && $request->id != "") :
                $concat = '';
                foreach ($request->orderitem as $del) {
                    $concat .= "'" . $del['id'] . "',";
                }
                $conditon = trim($concat, ",");

                DB::select("DELETE FROM order_item
                    WHERE penjualan_id = $request->id
                    AND id NOT IN ($conditon)");
            endif;

            foreach ($request->orderitem as $val) {
                $price = str_replace(".", "", $val['sale_price']);
                $total = (int) $val['qty'] * (int) $price;
                ItemPenjualan::UpdateOrCreate(['id' => $val['id']], [
                    'purchase_code' => $post->purchase_code,
                    'penjualan_id' => $post->id,
                    'product_id' => $val['product'],
                    'sell_price'   => str_replace(".", "", $val['sale_price']),
                    'qty'   => $val['qty'],
                    'size'   => $val['size'],
                    'total'   => $total,
                    'keterangan'   => $val['keterangan']
                ]);
            }

            DB::commit();

            return response()->json($post);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json($e);
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

    public function active(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $update = Penjualan::where(['id' => $request['id']])
            ->update(['status' => $request['data']]);

        return response()->json($update);
    }

    public function detail(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $data_detail = Penjualan::with('order_item', 'channel')
            ->where('penjualan.id', $id)
            ->get();
        $data = [];

        $data['data_detail'] = $data_detail;

        return response()->json($data);
    }

    public function get_data_product(Request $request, $id)
    {
        $penjualan = new Penjualan();
        $data_variant = $penjualan->get_data_variant($id);

        return response()->json($data_variant);
    }
}
