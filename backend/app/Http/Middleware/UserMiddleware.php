<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (
      ($request->header("x-access-token") && $user = PersonalAccessToken::findToken($request->header("x-access-token"))) ||
      ($request->bearerToken() && $user = PersonalAccessToken::findToken($request->bearerToken()))
    ) {
      $user = User::find($user->tokenable_id);

      if (!$user) return response()->json([
        "status" => false,
        "message" => "User not found",
        "errors" => null
      ], 404);

      if (!$user->isActive) {
        return response()->json([
          "status" => false,
          "message" => "Akun anda sudah dinonaktifkan",
          "errors" => null
        ], 422);
      }

      Auth::setUser($user);
      return $next($request);
    }


    return response()->json([
      "status" => false,
      "message" => "Unauthenticated!",
      "errors" => null
    ], 401);
  }
}
