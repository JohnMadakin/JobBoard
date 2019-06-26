<?php

namespace App\Http\Middleware;

class CheckUserScope
{

  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  mixed  ...$scopes
   * @return \Illuminate\Http\Response
   */
  public function handle($request, $next, ...$scopes)
  {
    if (!$request->user() || !$request->user()->token()) {
      return response()->json([
        'success' => false,
        'message' => 'Unauthorized.'
      ], 401);
    }

    foreach ($scopes as $scope) {
      if (!$request->user()->tokenCan($scope)) {
        return response()->json([
          'success' => false,
          'message' => 'You don\'t have the privilege to access this Route'
        ], 403);
      }
    }

    return $next($request);
  }
}
