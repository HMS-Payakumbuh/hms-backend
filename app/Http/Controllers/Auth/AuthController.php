<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Hash;
use JWTAuth;
use Log;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $input = $request->all();
    $input['password'] = Hash::make($request->input('password'));
    User::create($input);
    return response()->json(['result'=>true]);
  }

  public function login(Request $request)
  {
    $input = $request->all();
    if (!$token = JWTAuth::attempt($input)) {
      return response()->json(['result' => 'nomor pegawai atau password salah']);
    }
    return response()->json(['result' => $token]);
  }

  public function get_user_details(Request $request)
  {
    $input = $request->all();
    $user = JWTAuth::toUser($input['token']);
    return response()->json(['result' => $user]);
  }
}
