<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = "product";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function produksi()
    {
        return $this->hasMany('App\Produksi');
    }

    public function log_stock()
    {
        return $this->hasMany('App\Logstock');

    }
}
