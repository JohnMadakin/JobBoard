<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasApiTokens;

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

    public function profiles()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function roles()
    {
        return $this->belongsTo( 'App\Models\Role');
    }

}
