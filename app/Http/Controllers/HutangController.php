<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hutang;
use App\LogHutang;
use Illuminate\Support\Facades\DB;

class HutangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_view            = array();
        $data_view["title_h1"]               = "Data Hutang";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Hutang";
        $data_view["modal_title"]            = "Form Hutang";
        $data_view["card_title"]             = "Input & Update Data Hutang";

        if ($request->ajax()) {
            return datatables()->of(Hutang::all())
                ->addColumn('action', function ($data) {
                    $button = '<center>';
                    if (allowed_access(session('user'), 'hutang', 'edit')) :
                        $button = '<center><button type="button" class="btn btn-info btn-sm" onclick="history(' . $data->id . ')">History Pembayaran</button>';
                        $button .= '&nbsp;';
                        $button .= '<button type="button" class="btn btn-warning btn-sm" onclick="bayar(' . $data->id . ')">Pembayaran</button>';
                        $button .= '&nbsp;';
                        $button .= '<button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    endif;
                    $button .= '&nbsp;&nbsp;';
                    if (allowed_access(session('user'), 'hutang', 'delete')) :
                        $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    endif;
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('hutang/v_list', $data_view);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        $post = Hutang::UpdateOrCreate(["id" => $request['id']], [
            'name' => $request["name"],
            'jumlah_hutang' => str_replace(".", "", $request["jumlah_hutang"]),
            'sisa' => str_replace(".", "", $request["jumlah_hutang"]),
            'tanggal_hutang' => $request["tanggal_hutang"]
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

        $check_history = LogHutang::where('hutang_id', $id)->first();

        $history = false;
        if ($check_history) {
            $history = true;
        }


        $data = Hutang::where(["id" => $id])->first();
        $response = [];
        $response['data']   = $data;
        $response['history'] = $history;


        return response()->json($response);
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
        $delete = Hutang::find($id)->delete();

        return response()->json($delete);
    }

    public function bayar(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
       // dd($_POST);


        if ($request['tombol'] == 'pembayaran') {
            $jumlah_pembayaran = str_replace(".", "", $request['jumlah_pembayaran']);
            $sisa = $request['sisa'];


            if ($sisa < $jumlah_pembayaran) {
                $res = [
                    "status" => false,
                    "msg" => "jumlah pembayaran lebih besar dari sisa..."
                ];
                return response()->json($res);
                exit;
            }

            try {
                DB::beginTransaction();

                $sisa = $sisa - $jumlah_pembayaran < 0 ? 0 : $sisa - $jumlah_pembayaran;

                $log = [];
                $log['hutang_id'] = $request['id_hutang'];
                $log['jumlah_pembayaran'] =  str_replace(".", "", $request['jumlah_pembayaran']);
                $log['tanggal_pembayaran'] = $request['tanggal_pembayaran'];
                $log['keterangan'] = $request['tombol'];


                LogHutang::insert($log);


                $post = Hutang::where('id', $request['id_hutang'])
                    ->update(['sisa' => $sisa]);

                DB::commit();
                return response()->json($post);
                exit;
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json($e);
            }
        } else {
            //print_r($_POST);die;
            // Array ( [tombol] => revisi [id_hutang] => 1 [jumlah_hutang] => [sisa] => 66643 [jumlah_pembayaran] => 234 [tanggal_pembayaran] => 2021-10-30 )
            // Array ( [tombol] => revisi [id_hutang] => 1 [jumlah_hutang] => 66666 [sisa] => 66643 [jumlah_pembayaran] => 23 [tanggal_pembayaran] => 2021-10-30 )
            $sisa = $request['jumlah_hutang'] -  str_replace(".", "", $request['jumlah_pembayaran']);
            if ($sisa < 0) {
                $res = [
                    "status" => false,
                    "msg" => "jumlah pembayaran lebih besar dari sisa..."
                ];
                return response()->json($res);
                exit;
            }

            try {
                DB::beginTransaction();

                $log = [];
                $log['hutang_id'] = $request['id_hutang'];
                $log['jumlah_pembayaran'] =  str_replace(".", "", $request['jumlah_pembayaran']);
                $log['tanggal_pembayaran'] = $request['tanggal_pembayaran'];
                $log['keterangan'] = $request['tombol'];


                LogHutang::insert($log);


                $post = Hutang::where('id', $request['id_hutang'])
                    ->update(['sisa' => $sisa]);

                DB::commit();
                return response()->json($post);
                exit;
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json($e);
            }
        }
    }

    public function history(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $product = new Hutang();
        $data = $product->history($id);

        $data_view = [];
        $data_view['history'] = $data;
        $html = view('hutang/content', $data_view)->render();

        return response()->json(array('html' => $html));
    }
}
