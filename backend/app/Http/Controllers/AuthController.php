<?php

namespace App\Http\Controllers;

use App\Helpers\ValidationHelper;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  function login(Request $request)
  {
    $validation = new ValidationHelper;
    $validation->setRules("username", "Username", "required|string|max:255");
    $validation->setRules("password", "Password", "required|string|max:255");
    $validation->run();

    if ($validation->fails()) {
      return response()->json([
        "status" => false,
        "message" => null,
        "errors" => $validation->errors()
      ], 422);
    }

    $user = User::where("username", $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {

      if (!$user->isActive) {
        return response()->json([
          "status" => false,
          "message" => "Akun Anda sudah dinonaktifkan!",
          "errors" => null
        ], 422);
      }

      $tokenResult = $user->createToken("auth_user");
      $tokenResult->accessToken->where("tokenable_id", $tokenResult->accessToken->tokenable_id)->where('id', '!=', $tokenResult->accessToken->id)->delete();

      $token = $tokenResult->plainTextToken;

      $user->remember_token = $token;
      $user->save();

      return response()->json([
        "status" => true,
        "message" => "User found!",
        "record" => [
          "user" => $user,
          "token" => $token
        ]
      ], 200);
    }

    return response()->json([
      "status" => false,
      "message" => "Username atau Password Salah!",
      "errors" => null
    ], 422);
  }
}
