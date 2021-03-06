<?php

use Illuminate\Support\Facades\DB;


function customTanggal($date, $date_format)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
}

function customImagePath($image_name)
{
    return public_path('folder_kamu/sub_folder_kamu/' . $image_name);
}

function get_role($id)
{
    $role  = DB::select("  SELECT r.id
                            FROM users u
                            JOIN role r ON r.id = u.role
                            WHERE u.id = $id
                        ");

    return $role[0]->id;
}

function generate_purchase_code()
{
    do {
        $purchase_code = random('order');
        $verification = DB::select((" SELECT EXISTS
                                        (SELECT purchase_code FROM penjualan WHERE purchase_code ='{$purchase_code}')
                                         as verification"));
    } while ($verification[0]->verification == 1);
    return $purchase_code;
}

function generate_kode()
{
    do {
        $kode_produksi = random('produksi');
        $verification = DB::select((" SELECT EXISTS
                                    (SELECT kode_produksi FROM produksi WHERE kode_produksi ='{$kode_produksi}')
                                     as verification"));
    } while ($verification[0]->verification == 1);
    return $kode_produksi;
}

function random($param)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < 5; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    $year = date("Y");
    $date = date("m");
    $micro_date = microtime();
    $micro_dates = explode(" ", $micro_date);
    $micro_time = (substr($micro_dates[0], 2, 3) * 10) + rand(1, 999);

    switch ($param) {
        case "produksi":
            $generate_code = "PR" . $year . $date . $micro_time . $randomString;
            break;
        case "order":
            $generate_code = "PC" . $year . $date . $micro_time . $randomString;
            break;
        default:
            $generate_code = "PC" . $year . $date . $micro_time . $randomString;
    }

    return $generate_code;
}

function get_user_name($user_id)
{
    $name_user = DB::select("SELECT name FROM users WHERE id='{$user_id}'");
    if ($name_user) {
        return $name_user[0]->name;
    } else {
        return "user";
    }
}

function allowed_access($user, $module, $permission_name)
{
    if (get_role($user) == 1) {
        return true;
    } else {
        $allowed = DB::select(" SELECT a.permission
        FROM  module m
        JOIN access a ON a.module_id = m.id
        JOIN role_access ra ON ra.access_id = a.id
        JOIN role r ON ra.role_id = r.id
        JOIN users u ON u.role = r.id
        WHERE m.controller = '{$module}'
        AND a.permission = '{$permission_name}'
        AND u.id = {$user}
         ");
        if ($allowed) {
            return true;
        } else {
            return false;
        }
    }
}

function get_menu_build($id)
{
    if (get_role($id) == 1) {
        $module = DB::select("  SELECT m.name
                                ,m.controller
                                ,(SELECT m2.name FROM module m2 WHERE m2.id = m.parent_id AND m2.status = 1) as parent
                                ,(SELECT m3.order_no FROM module m3 WHERE m3.id = m.parent_id) as orders
                                FROM module m
                                -- JOIN access a ON a.module_id = m.id
                                -- JOIN role_access ra ON ra.access_id = a.id
                                -- JOIN role r ON ra.role_id = r.id
                                -- JOIN users u ON u.role = r.id
                                WHERE m.parent_id != 0
                                AND m.deleted_at IS NULL
                                -- AND a.permission ='view'
                                -- AND a.status = 1
                                -- AND a.deleted_at IS NULL
                                -- AND u.id = $id
                                ORDER BY m.order_no, orders ASC
                            ");
    } else {
        $module = DB::select("  SELECT m.name
                            ,m.controller
                            ,(SELECT m2.name FROM module m2 WHERE m2.id = m.parent_id AND m2.status = 1) as parent
                            ,(SELECT m3.order_no FROM module m3 WHERE m3.id = m.parent_id) as orders
                            FROM module m
                            JOIN access a ON a.module_id = m.id
                            JOIN role_access ra ON ra.access_id = a.id
                            JOIN role r ON ra.role_id = r.id
                            JOIN users u ON u.role = r.id
                            WHERE m.parent_id != 0
                            AND m.deleted_at IS NULL
                            AND a.permission ='view'
                            AND a.status = 1
                            AND a.deleted_at IS NULL
                            AND u.id = $id
                            ORDER BY m.order_no, orders ASC
                        ");
    }


    $modules = [];
    foreach ($module as $val) {
        if ($val->parent != "") {
            $modules[$val->parent][] = $val;
        }
    }

    $sidebar = '';
    foreach ($modules as $key => $vl) {
        $submenu = "";
        $class = array();
        foreach ($vl as $sub) {
            $link = url()->current();
            $explode  = explode("/", $link);
            $gurl = $explode[3];
            if (strtolower($gurl) == strtolower($sub->controller)) {
                $active = 'class="nav-link active"' . 'style="background-color:#f9f9f9c9;"';
                array_push($class, $active);
            } else {
                $active = 'class="nav-link"';
            }
            $submenu .= '<li class="nav-item" style="margin-left: 15px;">
                            <a href="' . URL::to('/' . $sub->controller . '') . '" ' . $active . '>
                                <i class="far fa-circle nav-icon"></i>
                                <p>' . $sub->name . '</p>
                            </a>
                        </li>';
        }

        if (in_array('class="nav-link active"' . 'style="background-color:#f9f9f9c9;"', $class)) {
            $pclass = 'class="nav-item menu-is-opening menu-open"';
            $display = 'style="display: block;"';
            $activc = 'class="nav-link active" style="background-color:#138496;"';
        } else {
            $pclass = 'class="nav-item"';
            $display = 'style="display: none;"';
            $activc = 'class="nav-link"';
        }

        $sidebar .= '<li ' . $pclass . '>
                        <a ' . $activc . '>
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                ' . $key . '
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" ' . $display . '>
                        ' . $submenu . '
                        </ul>
                    <li>';
    }
    return $sidebar;
}
