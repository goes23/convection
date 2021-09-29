<?php

namespace App\Http\Controllers;

use App\OrderProduksi;
use Illuminate\Http\Request;

class OrderProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data_view            = array();
        $data_view["title_h1"]               = "Data Order Order Produksi";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Order Order Produksi";
        $data_view["modal_title"]            = "Form Order Order Produksi";
        $data_view["card_title"]             = "Input & Update Data Order Order Produksi";
        if ($request->ajax()) {
            $list = OrderProduksi::all();
            return datatables()->of($list)
                ->addColumn('action', function ($data) {
                    $button = '<center>';
                    if (allowed_access(session('user'), 'order_produksi', 'edit')) :
                        $button .= '<button type="button" class="btn btn-warning btn-sm" onclick="bayar(' . $data->id . ')">Pembayaran</button>';
                        $button .= '&nbsp;';
                        $button .= '<a type="button" href="/order_produksi/' . $data->id . '/form" class="btn btn-success btn-sm" >Edit</a>';
                    // $button = '<center><button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    endif;
                    $button .= '&nbsp;&nbsp;';
                    if (allowed_access(session('user'), 'order_produksi', 'delete')) :
                        $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    endif;
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('order_produksi/v_list', $data_view);
    }

    public function form(Request $request, $id = '')
    {
        if ($id == '') {

            $data_view                = [];
            $data_view['h1']                     = 'Form Order Produksi';
            $data_view['breadcrumb_item']        = 'Order Produksi List';
            $data_view['breadcrumb_item_active'] = 'Form Order Produksi';
            $data_view['card_title']             = 'Form Order Produksi';
        } else {

            $data_produksi = OrderProduksi::where('id', $id)
                ->get();

            $data_view                = [];
            $data_view['h1']                     = 'Edit Form Order Produksi';
            $data_view['breadcrumb_item']        = 'Order Produksi List';
            $data_view['breadcrumb_item_active'] = 'Edit Form Order Produksi';
            $data_view['card_title']             = 'Edit Form Order Produksi';
            $data_view['data']                   = $data_produksi;
        }
        return view('order_produksi/v_form', $data_view);
    }


    public function create()
    {
        //
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

        if ($request['id'] == null) { // add

            $insert               = [];
            $insert['name']               = $request['name'];
            $insert['harga_modal_satuan'] = str_replace(".", "", $request['harga_modal_satuan']);
            $insert['harga_jual_satuan']  = str_replace(".", "", $request['harga_jual_satuan']);
            $insert['qty']                = $request['qty'];
            $insert['total_pembayaran']   = str_replace(".", "", $request['total_pembayaran']);
            $insert['sisa_pembayaran']    = str_replace(".", "", $request['total_pembayaran']);

            $insert = OrderProduksi::insert($insert);

            return response()->json($insert);
        } else {

            $update               = [];
            $update['name']               = $request['name'];
            $update['harga_modal_satuan'] = str_replace(".", "", $request['harga_modal_satuan']);
            $update['harga_jual_satuan']  = str_replace(".", "", $request['harga_jual_satuan']);
            $update['qty']                = $request['qty'];
            $update['total_pembayaran']   = str_replace(".", "", $request['total_pembayaran']);
            $update['sisa_pembayaran']    = str_replace(".", "", $request['total_pembayaran']);

            $update = OrderProduksi::where(['id' => $request['id']])
                ->update($update);


            return response()->json($update);
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
    public function edit($id)
    {
        //
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
        $delete = OrderProduksi::find($id)->delete();

        return response()->json($delete);
    }
}
