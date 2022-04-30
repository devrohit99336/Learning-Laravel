<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(Users::class,'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }
}
