<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bahan extends Model
{
    use SoftDeletes;

    protected $table = "bahan";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $fillable = ['kode', 'nama', 'harga', 'but_at', 'satuan', 'panjang'];


    public function produksi()
    {
        return $this->hasMany('App\Produksi');
    }
}
