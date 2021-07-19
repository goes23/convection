<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $link = url()->current();
        $explode  = explode("/", $link);
        $gurl = $explode[3];
        $user = session('user');

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
                            AND u.id = '{$user}'
                            AND m.name = '{$gurl}'
                            ORDER BY m.order_no, orders ASC
                        ");
    
        if ($module == []) {
            abort(404);
        }
        return $next($request);
    }
}
