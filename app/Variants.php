<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variants extends Model
{
    protected $table = "variants";
    protected $guarded = [];

    public function produksi()
    {
        //return $this->belongsTo('App\Penjualan', 'penjualan_id');

        return $this->belongsTo('App\Produksi', 'id');
    }
}
