<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderHeader;
use App\Channel;
use App\OrderItem;
use App\Product;
use Illuminate\Support\Facades\DB;
use stdClass;

class OrderHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_view            = array();
        $data_view["title_h1"]               = "Data Order Header";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Order Header";
        $data_view["modal_title"]            = "Form Order Header";
        $data_view["card_title"]             = "Input & Update Data Order Header";


        if ($request->ajax()) {
            return datatables()->of(OrderHeader::all())
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
                    if (allowed_access(session('user'), 'order_header', 'edit')) :
                        $button .= '<button type="button" class="btn btn-success btn-sm" onClick="edit(' . $data->id . ')">Edit</button>';
                    endif;
                    $button .= '&nbsp;';
                    if (allowed_access(session('user'), 'order_header', 'delete')) :
                        $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    endif;
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('order_header/v_list', $data_view);
    }

    public function form(Request $request)
    {

        if ($request->id != null) {
            $data_view                = [];
            $data_view['h1']                     = 'Form Order Header';
            $data_view['breadcrumb_item']        = 'Order Header List';
            $data_view['breadcrumb_item_active'] = 'Form Order Header';
            $data_view['card_title']             = 'Form Order';
            $data_view['channel']                = Channel::all();
            $data_view['product']                = Product::where('stock', '!=', 0)->get();
        } else {
            $data_order = OrderHeader::with('order_item')
                ->where('order_header.id', 2)
                ->get();

            // $order_header;                 
            foreach ($data_order as $item) :
                $order_header = $item;
            endforeach;




            $data_view                = [];
            $data_view['h1']                     = 'Edit Form Order Header';
            $data_view['breadcrumb_item']        = 'Edit Order Header List';
            $data_view['breadcrumb_item_active'] = 'Edit Form Order Header';
            $data_view['card_title']             = 'Edit Form Order';
            $data_view['channel']                = Channel::all();
            $data_view['product']                = Product::where('stock', '!=', 0)->get();
            $data_view['data_order']             = $data_order;
            $data_view['status']                 = 'edit';
        }

        return view('order_header/v_form', $data_view);
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $purcahe_code = generate_purchase_code();
        try {
            DB::beginTransaction();

            $post = OrderHeader::UpdateOrCreate(["id" => $request->id, "purchase_code" => $purcahe_code], [
                'purchase_code' => $purcahe_code,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'channel_id' => $request->channel,
                'purchase_date' => $request->purchase_date,
                'total_purchase' => 1,
                'shipping_price' =>  $request->shipping_price,
                'status' => 1
            ]);

            foreach ($request->orderitem as $val) {
                $price = str_replace(".", "", $val['price']);
                $total = (int) $val['qty'] * (int) $price;
                OrderItem::UpdateOrCreate(['id' => null], [
                    'purchase_code' => $purcahe_code,
                    'order_header_id' => $post->id,
                    'product_id' => $val['product'],
                    'sell_price'   => $price,
                    'qty'   => $val['qty'],
                    'total'   => $total
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

        $data = OrderHeader::where(["id" => $id])->first();

        return response()->json($data);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        $delete = OrderHeader::find($id)->delete();

        return response()->json($delete);
    }

    public function active(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $update = OrderHeader::where(['id' => $request['id']])
            ->update(['status' => $request['data']]);

        return response()->json($update);
    }

    public function detail(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $data_detail = OrderHeader::with('order_item')
            ->where('order_header.id', $id)
            ->get();
        $data = [];
        $order_header = [];
       
        foreach ($data_detail as $item) :
            $order_header['id'] = $item->id;
            $order_header['purchase_code'] = $item->purchase_code;
            $order_header['customer_name'] = $item->customer_name;
            $order_header['customer_phone'] = $item->customer_phone;
            $order_header['customer_address'] = $item->customer_address;
            $order_header['channel_id'] = $item->channel_id;
            $order_header['purchase_date'] = $item->purchase_date;
            $order_header['total_purchase'] = $item->total_purchase;
            $order_header['shipping_price'] = $item->shipping_price;
            $order_header['status'] = $item->status;
        endforeach;

        $data['order_header'] = $order_header;
        $data['data_detail'] = $data_detail;

        return response()->json($data);
    }
}
