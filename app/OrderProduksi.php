<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderProduksi extends Model
{
    protected $table = "order_produksi";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function history($id)
    {
        return DB::table('log_order_produksi')
            ->where('order_produksi_id', '=', $id)
            ->select(
                'log_order_produksi.jumlah_pembayaran',
                'log_order_produksi.keterangan',
                'log_order_produksi.tanggal_pembayaran'
            )
            ->paginate(10);
    }
}
