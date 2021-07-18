<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    protected $table = "role_access";
   // protected $fillable = ['role_id, access_id'];
    protected $guarded = [];

}
