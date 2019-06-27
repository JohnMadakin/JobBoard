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
  protected $hidden = [
    'deleted_at', 'updated_at'
  ];
  public function user()
  {
    return $this->belongsTo('App\Models\User', 'applicant_id', 'id');
  }

  public function job()
  {
    return $this->belongsTo('App\Models\Job', 'user_id', 'id');
  }

}
