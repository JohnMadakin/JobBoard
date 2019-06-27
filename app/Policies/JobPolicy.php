<?php
namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobPolicy
{

  public function updateJob(User $user, Job $job)
  {
    return $job->user_id === $user->id;
  }
}
