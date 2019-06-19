<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function profile()
    {
        return $this->hasOne('App\Models\Profile', 'userId', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany( 'App\Models\Role', 'userRoles', 'userId', 'id')->withTimestamps();
    }

    /**
     * Checks if User has access to $permissions.
     */
    public function hasAccess(array $permissions): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the user belongs to role.
     */
    public function inRole(string $role)
    {
        return $this->roles()->where('role', $role)->count() == 1;
    }
       
}