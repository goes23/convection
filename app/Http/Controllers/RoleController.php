<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;
use App\Role;
use App\Module;
use App\Roleaccess;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_module = Module::where('parent_id', '<>', 0)->get(); //di pindah tar

        $data_view                = array();
        $data_view["title_h1"]               = "Data Role";
        $data_view["breadcrumb_item"]        = "Home";
        $data_view["breadcrumb_item_active"] = "Role";
        $data_view["modal_title"]            = "Form Role";
        $data_view["card_title"]             = "Input & Update Data Role";
        $data_view["module"]                 = $data_module;

        if ($request->ajax()) {
            return datatables()->of(Role::where('id', '!=', 1)->get())
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
                    if (allowed_access(session('user'), 'role', 'edit')) :
                        $button = '<center><button type="button" class="btn btn-success btn-sm" onclick="edit(' . $data->id . ')">Edit</button>';
                    endif;
                    $button .= '&nbsp;&nbsp;';
                    if (allowed_access(session('user'), 'role', 'delete')) :
                        $button .= '<button type="button" class="btn btn-danger btn-sm" onClick="my_delete(' . $data->id . ')">Delete</button></center>';
                    endif;
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('role/v_list', $data_view);
    }


    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $id = $request["id"];

        $post = Role::UpdateOrCreate(["id" => $id], [
            'name' => $request["data"]["name"],
            'description' => isset($request["data"]["description"]) ? $request["data"]["description"] : '',
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

        $data = Role::where(["id" => $id])->first();

        return response()->json($data);
    }


    public function destroy(Request $request, $id)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }
        $delete = Role::find($id)->delete();

        return response()->json($delete);
    }

    public function active(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $update = Role::where(['id' => $request['id']])
            ->update(['status' => $request['data']]);

        return response()->json($update);
    }

    public function datarole(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $data = Role::where('id', '!=', 1)->get();

        return response()->json($data);
    }


    public function get_access(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $data_module_access = Module::with('access')
            ->where('module.parent_id', '!=', 0)
            ->get();

        $data_role_access = Roleaccess::select('access_id')
            ->where('role_id', $request['selected'])
            ->get();

        $data = [];
        $data = [
            "module_access" => $data_module_access,
            "role_access" => $data_role_access
        ];

        return response()->json($data);
    }

    public function add_role_access(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $delete = Roleaccess::where('role_id', $request["role_id"])->delete();

        if ($request["access_id"]) {
            foreach ($request["access_id"] as $val) {
                $insert = Roleaccess::insert([
                    'role_id' => $request["role_id"],
                    'access_id' => $val['value']
                ]);
            }
            return response()->json($insert);
        } else {
            return response()->json($delete);
        }
    }

    public function add_permission(Request $request)
    {
        if (!$request->ajax()) {
            return "error request";
            exit;
        }

        $insert = Access::UpdateOrCreate(['module_id' => $request['module_id'], 'permission' => $request['permission']], [
            'module_id' => $request['module_id'],
            'permission' => $request['permission'],
            'status' => 1,
            'created_by' => 1
        ]);

        return response()->json($insert);
    }
}
