<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
    use SoftDeletes;

    protected $table = "pengeluaran";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
