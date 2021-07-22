<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHeader extends Model
{
    use SoftDeletes;

    protected $table = "order_header";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function order_item()
    {
        return $this->hasMany('App\OrderItem');
    }
}
