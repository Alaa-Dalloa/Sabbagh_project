<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;
use Laratrust\Traits\LaratrustUserTrait;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Models\Role as RoleModel;

class Role extends LaratrustRole
{
    use LaratrustUserTrait;


    protected $fillable = [
        'name',
        'display_name',
        'description',
        
    ];

    public $guarded = [];


    public function users(){
    return $this->belongsToMany('App\Models\User','role_user', 'role_id', 'user_id');
  }
}
