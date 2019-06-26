<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobType extends Model
{

  use SoftDeletes;
  protected $table = 'jobTypes';
  /**
   * The attributes that are guarded.
   *
   * @var array
   */
  protected $guarded = [
    'id',
  ];


  function jobs()
  {
    return $this->hasMany('App\Models\Job');
  }

}
