<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Image;


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
                        $img = '<center><img src="'.asset('thumbnail/').'/'.$data['foto'].'" alt="" width="200" height="100"></center>';
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
            $post = Product::insert([
                'kode' => $request["kode"],
                'name' => $request["name"],
                'created_by' => session('user')
            ]);
        } else {
            if ($_FILES['file']['name'] == '') {
                $filename = $_FILES['file']['name'];
            } else {
                $image = $request->file('file');
                $filename = time() . '.' . $image->extension();

                $destinationPath = public_path('/thumbnail');

                $img = Image::make($image->path());

                $img->resize(100, 100, function ($constraint) {

                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $filename);

                $destinationPath = public_path('/assets/img');

                $image->move($destinationPath, $filename);
            }

            $post = Product::where(['id' => $request['id']])
                ->update([
                    "kode" =>  $request["kode"],
                    "name" =>  $request["name"],
                    "foto" =>  $filename,
                    "harga_jual" =>  $request["harga_jual"],
                    "harga_modal_product" =>  $request["harga_modal_product"],
                    'created_by' => session('user')
                ]);
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
        $delete = Product::find($id)->delete();

        return response()->json($delete);
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
}
