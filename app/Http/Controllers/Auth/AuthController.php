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
      return response()->json(['result' => 'Nomor pegawai atau password salah']);
    }
    return response()->json(['result' => $token]);
  }

  public function get_user_details(Request $request)
  {
    $input = $request->all();
    $user = JWTAuth::parseToken()->authenticate();
    return response()->json(['result' => $user]);
  }

  public function update_user_kategori(Request $request)
  {
    $input = $request->all();
    $user = User::where('no_pegawai', '=', $input['no_pegawai'])->first();
    $user->other = '{"kategori_antrian": "'.$input['kategori_antrian'].'"}';
    $user->save();
    return response()->json(['result' => $user]);
  }
}
