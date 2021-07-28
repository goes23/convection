<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $table = "order_item";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function order_header()
    {
        return $this->belongsTo('App\OrderHeader', 'order_header_id');
    }
}
