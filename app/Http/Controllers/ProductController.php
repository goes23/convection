<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Image;
use File;
use Illuminate\Support\Facades\DB;
use App\Produksi;
use App\Variants;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_view            = array();
        $data_view["title_h1"]               = "Data Product";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Product";
        $data_view["modal_title"]            = "Form Product";
        $data_view["card_title"]             = "Input & Update Data Product";


        if ($request->ajax()) {
            return datatables()->of(Product::all())
                ->addColumn('img', function ($data) {
                    $img = '';
                    if ($data['foto'] != null) {
                        $img = '<center><img src="' . asset('thumbnail/') . '/' . $data['foto'] . '" alt="" width="200" height="100"></center>';
                    }
                    return $img;
                })
                ->addColumn('action', function ($data) {
                    $button = '<center>';
                    if (allowed_access(session('user'), 'product', 'edit')) :
                        $button = '<center><button type="button" class="btn btn-warning btn-sm" onclick="stock(' . $data->id . ')">Stock</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    endif;
                    $button .= '&nbsp;&nbsp;';
                    if (allowed_access(session('user'), 'product', 'delete')) :
                        $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    endif;
                    return $button;
                })
                ->rawColumns(['action', 'img'])
                ->addIndexColumn()
                ->make(true);
        }
        // <img src="pic_trulli.jpg" alt="" width="500" height="333">

        return view('product/v_list', $data_view);
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

        if ($request["id"] == '') {
            $insert       = [];
            $insert['kode']       = $request["kode"];
            $insert['name']       = $request["name"];
            $insert['created_by'] = session('user');

            $post = Product::insert($insert);
        } else {
            $update = [];
            if ($_FILES['file']['name'] == '') {
                $update['kode']                = $request["kode"];
                $update['name']                = $request["name"];
                $update['harga_jual']          = str_replace(".", "", $request["harga_jual"]);
                $update['harga_modal_product'] = str_replace(".", "", $request["harga_modal_product"]);
                $update['created_by']          = session('user');
            } else {

                /* DELETE FOTO/FILE */
                $photoname = DB::table('product')->where('id', $request['id'])->first()->foto;

                $image_path = public_path('/assets/img/') . $photoname;
                $image_path_thumbnail = public_path('/thumbnail/') . $photoname;

                if (File::exists($image_path)) { // cek jika ada foto maka hapus
                    File::delete($image_path);
                    File::delete($image_path_thumbnail);
                }

                /* DELETE FOTO/FILE */

                /* RESIZE IMAGE & SAVE FOTO KE PATH */
                $image           = $request->file('file');
                $filename        = time() . '.' . $image->extension();
                $destinationPath = public_path('/thumbnail');
                $img             = Image::make($image->path());

                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $filename);

                $destinationPath = public_path('/assets/img');
                $image->move($destinationPath, $filename);

                /* RESIZE IMAGE & SAVE FOTO KE PATH */

                $update['kode']                = $request["kode"];
                $update['name']                = $request["name"];
                $update['foto']                = $filename;
                $update['harga_jual']          = str_replace(".", "", $request["harga_jual"]);
                $update['harga_modal_product'] = str_replace(".", "", $request["harga_modal_product"]);
                $update['created_by']          = session('user');
            }

            $post = Product::where(['id' => $request['id']])
                ->update($update);
        }

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

        $data = Product::where(["id" => $id])->first();

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

        $check_produksi = Produksi::where("product_id", $id)->exists();
        if (!$check_produksi) {
            $delete = Product::find($id)->delete();
            return response()->json($delete);
        } else {
            $res = [
                "status" => false,
                "msg" => "Product sedang di proses di produksi ..!!!"
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

        $update = Product::where(['id' => $request['id']])
            ->update(['status' => $request['data']]);

        return response()->json($update);
    }

    public function get_data_produksi(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        $data = Produksi::where('product_id', $id)->get();


        return response()->json($data);
    }

    public function get_data_variants(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        $data = Variants::where('produksi_id', $id)->get();

        return response()->json($data);
    }
}
