<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogHutang extends Model
{
    protected $table = "log_hutang";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
