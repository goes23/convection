<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produksi extends Model
{
    use SoftDeletes;

    protected $table = "produksi";
    protected $guarded = [];
    protected $dates = ['deleted_at'];


    public function bahan()
    {
        return $this->belongsTo('App\Bahan','bahan_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

}
