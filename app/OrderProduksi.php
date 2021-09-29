<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduksi extends Model
{
    protected $table = "order_produksi";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
