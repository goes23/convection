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
                            v.product_id
                            ,v.size
                            ,(SELECT harga_jual FROM product as p WHERE p.id = v.product_id LIMIT 1 ) as harga_jual
                            ,SUM(v.jumlah_stock_product) as jumlah_stock_product
                             FROM variants as v
                             WHERE v.product_id = $id
                             AND v.jumlah_stock_product > 0
                             GROUP BY v.size
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

    public function get_data_order($id)
    {
        return  DB::select("SELECT id
        ,purchase_code
        ,kode_pesanan
        ,customer_name
        ,customer_phone
        ,customer_address
        ,channel_id
        ,purchase_date
        ,total_purchase
        ,shipping_price FROM penjualan WHERE id = $id");
    }

    public function get_data_item($pc)
    {
        $test = DB::select(" SELECT i.id
                                    ,i.purchase_code
                                    ,i.penjualan_id
                                    ,(SELECT harga_jual FROM product WHERE product.id = i.product_id ) as harga_jual
                                    ,(SELECT jumlah_stock_product FROM variants WHERE variants.product_id = i.product_id  AND variants.size = i.size ) as jumlah_stock_product
                                    ,(SELECT GROUP_CONCAT(size) FROM variants WHERE variants.product_id = i.product_id ) as size_concat
                                    ,i.product_id
                                    ,i.sell_price
                                    ,i.qty
                                    ,i.size
                                    ,i.total
                                    ,i.keterangan
                             FROM item_penjualan as i
                             WHERE purchase_code = '$pc'
                            ");

        return $test;
    }
}
