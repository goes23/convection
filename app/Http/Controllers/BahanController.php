<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bahan;
use App\Produksi;

class BahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_view            = array();
        $data_view["title_h1"]               = "Data Bahan";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Bahan";
        $data_view["modal_title"]            = "Form Bahan";
        $data_view["card_title"]             = "Input & Update Data Bahan";

        if ($request->ajax()) {
            return datatables()->of(Bahan::all())
                ->addColumn('action', function ($data) {
                    $button = '<center>';
                    if (allowed_access(session('user'), 'bahan', 'edit')) :
                        $button = '<center><button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    endif;
                    $button .= '&nbsp;&nbsp;';
                    if (allowed_access(session('user'), 'bahan', 'delete')) :
                        $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    endif;
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('bahan/v_list', $data_view);
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
        $harga = str_replace(".", "", $request["data"]["harga"]);

        $post = Bahan::UpdateOrCreate(["id" => $id], [
            'kode' => $request["data"]["kode"],
            'name' => $request["data"]["name"],
            'buy_at' => $request["data"]["buy_at"],
            'harga' => str_replace(".", "", $harga),
            'panjang' => $request["data"]["panjang"],
            'satuan' => $request["data"]["satuan"],
            'sisa_bahan' => $request["data"]["panjang"],
            'harga_satuan' => str_replace(".", "", $request["data"]["harga_satuan"]),
            'discount' => $request["data"]["discount"],
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

        $data = Bahan::where(["id" => $id])->first();

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

        $check_produksi = Produksi::where("bahan_id", $id)->exists();
        if (!$check_produksi) {
            $delete = Bahan::find($id)->delete();
            return response()->json($delete);
        } else {
            $res = [
                "status" => false,
                "msg" => "Bahan sedang di proses di produksi ..!!!"
            ];
            return response()->json($res);
        }
    }

    public function active(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $update = Bahan::where(['id' => $request['id']])
            ->update(['status' => $request['data']]);

        return response()->json($update);
    }
}
