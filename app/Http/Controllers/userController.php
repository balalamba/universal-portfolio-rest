<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
class userController extends Controller
{
    public function signup(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|email|unique:users',
    		'password' => 'required',
    		]);

    		$user = new User([
    			'name' => $request->input('name'),
    			'email' => $request->input('email'),
    			'password' => bcrypt($request->input('password'))
    			]);
    		$user->save();
    		return response()->json([
    			'message' => 'User created!'
    			],201);
    }
      public function signin(Request $request){
    $this->validate($request, [
      // 'name' => 'required',
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $credentials = $request->only('email','password');
    $user = User::where('email', $request->email)->first();
    unset($user->id,$user->created_at,$user->updated_at);
    $userDetails = ['name' => $user->name, 'email' => $user->email, 'isAdmin' => $user->isAdmin, 'isActive' => $user->isActive];
    try {
      if (!$token = JWTAuth::attempt($credentials, $userDetails)) {
        return response()->json([
          'error'=> 'Invalid credentials'
        ],401);
      }
    }
    catch (JWTException $e){
      return response()->json([
        'error'=> 'Could not create token'
      ],500);
    }

    return response()->json([
      'user' => $user,
      'token' => $token,
    ],200);
  }
};
