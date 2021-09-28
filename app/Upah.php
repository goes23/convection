<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Upah extends Model
{
    use SoftDeletes;

    protected $table = "upah";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function history($id)
    {
        return DB::table('pembayaran')
            ->where('upah_id', '=', $id)
            ->select(
                'pembayaran.jumlah_pembayaran',
                'pembayaran.keterangan',
                'pembayaran.tanggal_pembayaran'
            )
            ->paginate(10);
    }
}
