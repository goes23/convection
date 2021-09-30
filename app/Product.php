<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use SoftDeletes;

    protected $table = "product";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function produksi()
    {
        return $this->hasMany('App\Produksi');
    }

    public function log_stock()
    {
        return $this->hasMany('App\Logstock');
    }

    public function variants()
    {
        return $this->hasMany('App\Variants');
    }

    public function history($id)
    {

        return DB::table('log_stock')
            ->join('product', 'log_stock.product_id', '=', 'product.id')
            ->where('log_stock.product_id', '=', $id)
            ->select(
                'product.name',
                'log_stock.produksi_id',
                DB::raw("(SELECT size FROM variants WHERE variants.id = log_stock.variant_id) as size"),
                'log_stock.qty',
                'log_stock.transaksi',
                'log_stock.keterangan',
                'log_stock.transfer_date'
            )
            ->paginate(10);
    }
}
