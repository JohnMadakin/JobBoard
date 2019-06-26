<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{

  /**
   * The attributes that are guarded.
   *
   * @var array
   */
  protected $guarded = [
    'id',
  ];

  public function owner()
  {
    return $this->belongsTo('App\Models\User');
  }

  public function job()
  {
    return $this->belongTo('App\Models\Job');
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
