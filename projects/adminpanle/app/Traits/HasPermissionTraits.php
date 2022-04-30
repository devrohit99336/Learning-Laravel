<?php
namespace App\Traits;
use App\Models\Permission;
use App\Models\Role;

trait HasPermissionTraits
{

    public function getAllPermission($permission)
    {
        return Permission::where('slug', $permission)->get();
    }

    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function hasRole(...$role)
    {
        foreach ($role as $r) {
            if ($this->roles->contains('slug', $r->slug)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function givePermissionTo(...$permissions)
    {
        $permissions = $this->getAllPermission($permissions);
        if ($permissions === null) {
            return $this;
        }
        $this->permission()->saveMany($permissions);
        return $this;
    }


}
