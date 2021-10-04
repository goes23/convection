<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogOrderProduksi extends Model
{
    protected $table = "log_order_produksi";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
