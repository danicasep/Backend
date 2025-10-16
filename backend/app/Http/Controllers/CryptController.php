<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptController extends Controller
{
  function nodeHeader(Request $request)
  {
    $bearer = $request->bearerToken();
    try {
      $decrypted = decrypt($bearer);
      if ($decrypted !== env("TOKEN_NODE")) {
        throw new \Exception("Invalid token");
      }
      return response()->json([
        "status"  => true,
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        "status"  => false,
        "message" => "Invalid token"
      ], 401);
    }
  }
}
