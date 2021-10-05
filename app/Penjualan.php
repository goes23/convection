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

    public function get_data_products()
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
                            ,size
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
                                ,shipping_price
                            FROM penjualan
                            WHERE id = $id");
    }

    public function get_data_item($pc)
    {
        $data = DB::select(" SELECT * FROM item_penjualan ip WHERE ip.penjualan_id = $pc ");

        return $data;
    }

    public function jumlah_stock_product($param)
    {
        $size = $param['size'];
        $product_id = $param['id'];
        return DB::select(" SELECT SUM(v.jumlah_stock_product) as jumlah_stock_product
                             FROM variants v
                             WHERE v.size = '$size'
                             AND v.product_id = $product_id
                             GROUP BY v.product_id
        ");
    }
}
