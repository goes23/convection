<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Module;
use App\Access;
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
            return datatables()->of(Module::orderBy('parent_id', 'ASC')
                                    //->selectRaw('select mm.name from module mm where mm.id = module.parent_id ')
                                    ->orderBy('order_no', 'ASC')
                                    ->get())
                ->addColumn('order_no', function ($data) {
                    $orderno = '<span id="order-' . $data->id . '">' . $data->order_no . '</span>
                    <span class="float-right">
                        <button type="button" class="btn btn-light btn-sm" onclick="functionUp(this)" value="' . $data->id . '" ><i class="fas fa-angle-up"></i></button> 
                        <button type="button" class="btn btn-light btn-sm" onclick="functionDown(this)" value="' . $data->id . '" ><i class="fas fa-angle-down"></i></button>
                    </span>';
                    return $orderno;
                })
                ->rawColumns(['order_no'])
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
                ->rawColumns(['action', 'status', 'order_no'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('module/v_list', $data_view);
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        $id = $request["id"];

        if ($request['data']['parent'] == 0) {
            $post = Module::UpdateOrCreate(["id" => $id], [
                'parent_id' => $request["data"]["parent"],
                'name' => $request["data"]["name"],
                'controller' => isset($request["data"]["controller"]) ? strtolower($request["data"]["controller"]) : "",
                'order_no' => $request["data"]["order"],
                'status' => $request["data"]["status"],
            ]);

            return response()->json($post);
        } else {
            try {
                DB::beginTransaction();

                $post = Module::UpdateOrCreate(["id" => $id], [
                    'parent_id' => $request["data"]["parent"],
                    'name' => $request["data"]["name"],
                    'controller' => isset($request["data"]["controller"]) ? strtolower($request["data"]["controller"]) : "",
                    'order_no' => $request["data"]["order"],
                    'status' => $request["data"]["status"],
                ]);


                $permission = [
                    0 => "view",
                    1 => "add",
                    2 => "edit",
                    3 => "delete"
                ];

                for ($i = 0; $i < count($permission); $i++) {
                    Access::UpdateOrCreate(["module_id" => $post->id, "permission" => $permission[$i]], [
                        'permission' => $permission[$i],
                        'status' => 1,
                        'created_by' => session('user')
                    ]);
                }


                DB::commit();

                return response()->json($post);
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json($e);
            }
        }
    }

    public function edit(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $data = Module::where(["id" => $id])->first();

        return response()->json($data);
    }

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


    public function updatenorder(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $update = Module::where('id', $request['id'])
            ->update([
                'order_no' => $request["order_no"]
            ]);

        return response()->json($update);
    }
}
