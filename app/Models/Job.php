<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{

  use SoftDeletes;

  /**
   * The attributes that are guarded.
   *
   * @var array
   */
  protected $guarded = [
    'id',
  ];
  protected $hidden = [
    'deleted_at',
  ];

  public function specs()
  {
    return $this->belongsTo('App\Models\Spec', 'spec_id', 'id');
  }

  public function owner()
  {
    return $this->belongsTo('App\Models\User');
  }
  public function jobTypes()
  {
    return $this->belongsTo('App\Models\JobType', 'jobType_id', 'id');
  }

  public function applicants()
  {
    return $this->hasMany('App\Models\Applicant');
  }
  
}
