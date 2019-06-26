<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Exception;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use League\OAuth2\Server\Exception\OAuthServerException;
use \Laravel\Passport\Http\Middleware\CheckClientCredentials;


class UsersAuthorizations extends CheckClientCredentials
{

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  mixed  ...$scopes
   * @return mixed
   * @throws \Illuminate\Auth\AuthenticationException
   */
  public function handle($request, Closure $next, ...$scopes)
  {
    $psr = (new DiactorosFactory)->createRequest($request);

    try {
      $psr = $this->server->validateAuthenticatedRequest($psr);
    } catch (OAuthServerException $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getHint(),
      ], 401);      
    }

    $this->validateScopes($psr, $scopes);

    return $next($request);
  }


}
