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
  public function users()
  {
    return $this->hasMany('App\Models\User');
  }

}
