<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upah extends Model
{
    use SoftDeletes;

    protected $table = "upah";
    protected $guarded = [];
    protected $dates = ['deleted_at'];


}
