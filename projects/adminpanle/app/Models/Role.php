<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];
    public function users()
    {
        return $this->belongsToMany(Users::class,'users_permissions');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }
}
