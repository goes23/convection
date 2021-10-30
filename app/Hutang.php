<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Hutang extends Model
{
    use SoftDeletes;

    protected $table = "hutang";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function history($id)
    {
       // dd("m");
        return DB::table('log_hutang')
            ->where('hutang_id', '=', $id)
            ->select(
                'log_hutang.jumlah_pembayaran',
                'log_hutang.keterangan',
                'log_hutang.tanggal_pembayaran'
            )
            ->paginate(10);
    }
}
