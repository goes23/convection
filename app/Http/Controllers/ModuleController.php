<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use PDO;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $parent = Module::where('parent_id', 0)->get();
        $data_view            = array();
        $data_view["title_h1"]               = "Data Module";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Module";
        $data_view["modal_title"]            = "Form Module";
        $data_view["card_title"]             = "Input & Update Data Module";
        //$data_view["parent"]                 = $parent;

        if ($request->ajax()) {
            return datatables()->of(Module::all())
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        $button = '<center><button type="button" class="btn btn-warning btn-sm" onclick="active(' . $data->id . ',0)"> Enabled </button> </center>';
                    } else {
                        $button = '<center><button type="button" class="btn btn-sm" style="background-color: #cccccc;" onclick="active(' . $data->id . ',1)"> Disabled </button> </center>';
                    }
                    return $button;
                })
                ->rawColumns(['status'])
                ->addColumn('action', function ($data) {
                    $button = '<center><button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('module/v_list', $data_view);
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

        $id = $request["id"];

        $post = Module::UpdateOrCreate(["id" => $id], [
            'parent_id' => $request["data"]["parent"],
            'name' => $request["data"]["name"],
            'controller' => isset($request["data"]["controller"]) ? $request["data"]["controller"] : "",
            'order_no' => $request["data"]["order"],
            'status' => $request["data"]["status"],
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

        $data = Module::where(["id" => $id])->first();

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
        $delete = Module::find($id)->delete();

        return response()->json($delete);
    }

    public function active(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $update = Module::where(['id' => $request['id']])
            ->update(['status' => $request['data']]);

        return response()->json($update);
    }

    public function dataparent(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $parent = Module::where('parent_id', 0)->get();

        return response()->json($parent);
    }
}
