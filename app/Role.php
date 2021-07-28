<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = "role";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->hasMany('App\User');

    }
}
