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

    public function order_item()
    {
        return $this->hasMany('App\PenjualanItem');
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
                            GROUP BY product.id
                            ");
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
}
