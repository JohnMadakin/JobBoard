<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spec extends Model
{

  /**
   * The attributes that are guarded.
   *
   * @var array
   */
  protected $guarded = [
    'id',
  ];
  protected $hidden = [
    'deleted_at', 'created_at', 'updated_at'
  ];


  public function profiles()
  {
    return $this->hasMany('App\Models\Profile');
  }
  public function jobs()
  {
    return $this->hasMany('App\Models\Job');
  }
}
