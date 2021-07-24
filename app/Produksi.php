<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Produksi extends Model
{
    use SoftDeletes;

    protected $table = "produksi";
    protected $guarded = [];
    protected $dates = ['deleted_at'];


    public function bahan()
    {
        return $this->belongsTo('App\Bahan', 'bahan_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function get_data_produksi($bahan, $product)
    {
        return  DB::select("SELECT * 
                            FROM produksi 
                            WHERE bahan_id='{$bahan}' 
                            AND product_id='{$product}' 
                            AND deleted_at IS NULL
                            LIMIT 1");
    }
}
