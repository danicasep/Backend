<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class PublicMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $publicToken = $request->header('x-token');
    try {
      if (Hash::check(env("PUBLIC_TOKEN"), $publicToken )) {
        return $next($request);
      }
      return response()->json(['message' => 'Unauthorized'], 401);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 401);
    }
  }
}
