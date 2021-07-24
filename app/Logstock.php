<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Logstock extends Model
{
    use SoftDeletes;

    protected $table = "log_stock";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function get_data_produksi()
    {
        return DB::select("SELECT id , bahan_id, product_id ,
                            (SELECT name FROM product pr WHERE pr.id = p.product_id) as name
                            FROM produksi p 
                            WHERE p.deleted_at IS NULL 
                            AND p.status = 1");
    }

    public function update_stock_product($id, $qty)
    {
        $stock = DB::select(" SELECT pr2.stock FROM product pr2 WHERE id = '{$id}'");

        $stock_update = (int) $stock[0]->stock + (int) $qty;

        return DB::select("UPDATE product 
                            SET stock = '{$stock_update}'
                            WHERE id = '{$id}'
                            ");
    }

    public function update_sisa_produksi($id, $qty)
    {
        $sisa = DB::select(" SELECT pr.sisa FROM produksi pr WHERE pr.id = '{$id}'");
        $update_sisa = (int) $sisa[0]->sisa - (int) $qty;


        return DB::select("UPDATE produksi 
                            SET sisa = '{$update_sisa}'
                            WHERE id = '{$id}'
                            ");
    }
}
