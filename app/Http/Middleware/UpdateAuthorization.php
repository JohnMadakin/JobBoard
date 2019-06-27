<?php

namespace App\Http\Middleware;


use Exception;
use Closure;
use App\Http\Helpers\ControllerHelpers;
use App\Http\Services\JobService;

class UpdateAuthorization
{

  /**
   * Handle an incoming request and Authorizes the user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
  public function handle($request, Closure $next, $guard = null)
  {
    $jobId = $request->id;
    $job = new JobService();
    $getJob = $job->getJobModel($jobId);

    if ($request->user()->can('updateJob', $getJob)) {
      return $next($request);
    }
    return response()->json([
      'success' => false,
      'message' => 'You are not authorized to carry this action'
    ], 403);
  }
}
