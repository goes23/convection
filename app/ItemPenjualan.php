<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemPenjualan extends Model
{
    use SoftDeletes;

    protected $table = "item_penjualan";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function penjualan()
    {
        return $this->belongsTo('App\Penjualan', 'penjualan_id');
    }
}
