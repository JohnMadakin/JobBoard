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

  function owner()
  {
    return $this->belongsTo('App\Models\User');
  }
  function jobTypes()
  {
    return $this->belongsTo('App\Models\JobType');
  }

  function applicants()
  {
    return $this->hasMany('App\Models\Applicant');
  }

  public function publishJob($query)
  {
    return $query->where('published', true);
  }

  public function unpublishJob($query)
  {
    return $query->where('published', false);
  }
}
