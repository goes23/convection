<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderHeader;
use App\Channel;
use App\Product;

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
                    if (allowed_access(session('user'), 'order_header', 'edit')) :
                        $button = '<center><button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    endif;
                    $button .= '&nbsp;&nbsp;';
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
        $data_view                = [];
        $data_view['h1']                     = 'Form Order Header';
        $data_view['breadcrumb_item']        = 'Order Header List';
        $data_view['breadcrumb_item_active'] = 'form Order Header';
        $data_view['card_title']             = 'Form Order';
        $data_view['channel']                = Channel::all();
        $data_view['product']                = Product::where('stock', '!=', 0)->get();

        return view('order_header/v_form', $data_view);
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        dd($request);

        $id = $request["id"];
        $harga_modal = str_replace(".", "", $request["data"]["harga_modal"]);

        $post = OrderHeader::UpdateOrCreate(["id" => $id], [
            'kode' => $request["data"]["kode"],
            'name' => $request["data"]["name"],
            'harga_modal' => $harga_modal,
            'stock' => $request["data"]["stock"] == '' ? 0 : $request["data"]["stock"],
            'status' => $request["data"]["status"],
            'created_by' => session('user')

        ]);


        return response()->json($post);
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
}