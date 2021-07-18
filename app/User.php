<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = "users";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    //protected $primaryKey = 'id';

    public function role()
    {
        return $this->belongsTo('App\Role', 'role');
    }
}
