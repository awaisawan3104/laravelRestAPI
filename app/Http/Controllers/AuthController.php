<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
         public function register(Request $request)
   {
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors()], 401);
    }

    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $accessToken = $user->createToken('authToken')->accessToken;
    return response()->json(['user' => $user, 'access_token' => $accessToken]);
}

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $accessToken = $user->createToken('authToken')->accessToken;
        return response()->json(['user' => $user, 'access_token' => $accessToken]);
    } else {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}

}
