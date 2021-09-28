<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hutang extends Model
{
    use SoftDeletes;

    protected $table = "hutang";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
