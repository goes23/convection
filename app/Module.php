<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    protected $table = "module";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function access()
    {
       // return $this->belongsTo('App\Access','module_id');
        return $this->hasMany('App\Access');
    }
}
