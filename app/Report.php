<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    // public function get_module()
    // {
    //     return  DB::select("SELECT *
    //                         FROM produksi
    //                         WHERE bahan_id='{$bahan}'
    //                         AND product_id='{$product}'
    //                         AND deleted_at IS NULL
    //                         LIMIT 1");
    // }
}
