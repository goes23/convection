<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes;

    protected $table = "channel";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function penjualan()
    {
        return $this->hasMany('App\Penjualan');
    }
}
