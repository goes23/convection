<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    use SoftDeletes;

    protected $table = "penjualan";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function item_penjualan()
    {
        return $this->hasMany('App\ItemPenjualan');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel', 'channel_id');
    }

    public function get_data_product()
    {
        return DB::select(" SELECT
                            product.id
                            ,product.name
                            FROM product
                            JOIN variants ON variants.product_id = product.id
                            -- WHERE variants.jumlah_stock_product IS NOT NULL
                            WHERE variants.jumlah_stock_product > 0
                            GROUP BY product.id
                            ");
        //dd($test);
    }


    public function get_data_variant($id)
    {
        return DB::select(" SELECT
                            product.id
                            ,product.name
                            ,product.harga_jual
                            ,variants.size
                            ,variants.id as v_id
                            ,variants.jumlah_stock_product
                            FROM product
                            JOIN variants ON variants.product_id = product.id
                            WHERE variants.jumlah_stock_product IS NOT NULL
                            ");
    }

    public function detail($id)
    {
        return DB::select(" SELECT
                            purchase_code
                            ,(SELECT name FROM product WHERE product.id = item_penjualan.product_id ) as product_name
                            ,sell_price
                            ,qty
                            ,(SELECT size FROM variants WHERE variants.id = item_penjualan.size ) as size
                            ,total
                            FROM item_penjualan
                            WHERE penjualan_id = $id
                            ");
    }
}
