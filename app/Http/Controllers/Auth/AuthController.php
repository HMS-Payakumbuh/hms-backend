<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
  private $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function register(RegisterRequest $request)
  {
    $newUser = $this->user->create([
      'name' => $request->get('name'),
      'role' => $request->get('role'),
      'email' => $request->get('email'),
      'password' => bcrypt($request->get('password'))
    ]);
    if (!$newUser) {
      return response('failed_to_create_new_user', 500);
    }
    //TODO: implement JWT
    return response('user_created');
  }

  public function login(LoginRequest $request)
  {
    //TODO: authenticate JWT
  }
}
