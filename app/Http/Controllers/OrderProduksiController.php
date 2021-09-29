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
        // $data_bahan = Bahan::where('sisa_bahan', '<>', 0)
        //     ->select('id', 'kode', 'name', 'panjang', 'sisa_bahan')
        //     ->get();

        // $data_product = Product::all();

        $data_view                = [];
        $data_view['h1']                     = 'Form Order Produksi';
        $data_view['breadcrumb_item']        = 'Order Produksi List';
        $data_view['breadcrumb_item_active'] = 'Form Order Produksi';
        $data_view['card_title']             = 'Form Order Produksi';
        // $data_view["bahan"]                  = $data_bahan;
        // $data_view["product"]                = $data_product;
        // $data_view["size"]                   = $size;


        // if ($id == "") {
        //     $data_view['status']                 = 0; // status add
        //     $data_view['data_produksi']          = [];
        // } else {
        //     $data_produksi = OrderProduksi::with('variants')
        //         ->where('produksi.id', $id)
        //         ->get();
        //     //dd($data_produksi);

        //     $data_view['data_produksi']          = $data_produksi;
        //     $data_view['status']                 = 1;  // status edit
        // }
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
        //
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
    public function destroy($id)
    {
        //
    }
}
