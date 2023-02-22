<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
   


  public function store(Request $request)
{
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
    ]);

    return response()->json([
        'message' => 'User created successfully.',
        'user' => $user,
    ]);
}

  

}
