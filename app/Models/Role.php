<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

  /**
   * The attributes that are guarded.
   *
   * @var integer
   */
  protected $guarded = [
    'id',
  ];
  protected $casts = [
    'permissions' => 'array',
  ];

  public function users()
  {
    return $this->hasMany('App\Models\User');
  }

  /**
   * checks if the string is in the array of permissions
   *
   * @var array
   */
  private function hasPermission(string $permission): bool
  {
    return $this->permissions[$permission] ?? false;
  }


  /**
   * checks if the role has the required permission
   *
   * @var array
   */
  public function hasAccess(array $permissions): bool
  {
    foreach ($permissions as $permission) {
      if ($this->hasPermission($permission))
        return true;
    }
    return false;
  }


  // function user()
  // {
  //   return $this->belongsTo('App\Models\User', 'userId', 'id');
  // }
}
