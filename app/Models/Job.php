<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

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
    return $this->belongsTo('App\Models\User', 'userId', 'id');
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
