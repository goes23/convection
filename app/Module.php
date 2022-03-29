<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    use SoftDeletes;

    protected $table = "module";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function data_module()
    {
        return DB::select("SELECT m.*,(SELECT name
                                FROM module m2
                                WHERE m2.id = m.parent_id) as parent_name
                    FROM module m
                    -- ORDER BY m.parent_id, order_no ASC
                    ");
    }

    public function access()
    {
       // return $this->belongsTo('App\Access','module_id');
        return $this->hasMany('App\Access');
    }


}
