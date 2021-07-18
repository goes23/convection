<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access extends Model
{
    use SoftDeletes;

    protected $table = "access";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function module()
    {
        //return $this->hasMany('App\Module');
        return $this->belongsTo('App\Module');
    }
}
