<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
  public function register(request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email',
      'confirm_password' => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'massage' => 'salah',
        'data' => $validator->error()
      ]);
    }

    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);

    $success['token'] = $user->createToken('auth_token')->plainTextToken;
    $success['name'] = $user->name;

    return response()->json([
      'success' => true,
      'massage' => 'Success Register',
      'data' => $success
    ]);
  }

  public function login(Request $request)
  {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      $auth = Auth::user();
      $success['token'] = $auth->createToken('auth_token')->plainTextToken;
      $success['name'] = $auth->name;

      return response()->json([
        'success' => true,
        'massage' => 'success register',
        'data' => $success
      ]);
    } else {
      return response()->json([
        'success' => false,
        'massage' => 'data yang di masukan salah!',
        'data' => null
      ]);
    }
  }
}
