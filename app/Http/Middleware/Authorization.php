<?php

namespace App\Http\Middleware;


use Exception;
use Closure;
use App\Http\Helpers\ControllerHelpers;

class Authorization
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
    $profileId = $request->user()->profiles->id ?? $request->user()->profileId;
    if($request->id == $profileId){
      return $next($request);
    }
    return response()->json([
      'success' => false,
      'message' => 'sorry, you can only edit your profile'
    ], 403);

  }
}
