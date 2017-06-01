<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;

class JwtAuthenticateController extends Controller
{

    public function getAllUsers()
    {
        //return response()->json(['auth'=>Auth::user(), 'users'=>User::all()]);
        return response()->json(['users'=>User::all()]);
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
          'email' => 'required|email',
          'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        $rolesToCheck = array("admin");
        function checkRoles($user,$rolesToCheck) {
            foreach ($rolesToCheck as $i => $value) {
                if($user->hasRole($rolesToCheck[$i])) {
                    return $rolesToCheck[$i];
                }
            }
        };
        $credentials = $request->only('email', 'password');
        $userRole = checkRoles($user,$rolesToCheck);
        $userDetails = ['name' => $user->name, 'email' => $user->email, 'role' => $userRole];
        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials, $userDetails)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }

    public function createRole(Request $request){

        $role = new Role();
        $role->name = $request->input('name');
        $role->save();

        return response()->json("created");

    }

    public function createPermission(Request $request){

        $viewUsers = new Permission();
        $viewUsers->name = $request->input('name');
        $viewUsers->save();

        return response()->json("created");

    }

    public function assignRole(Request $request){
        $user = User::where('email', '=', $request->input('email'))->first();
        $role = Role::where('name', '=', $request->input('role'))->first();
        //$user->attachRole($request->input('role'));
        $user->roles()->attach($role->id);

        return response()->json("created");
    }

    public function attachPermission(Request $request){
        $role = Role::where('name', '=', $request->input('role'))->first();
        $permission = Permission::where('name', '=', $request->input('name'))->first();
        $role->attachPermission($permission);

        return response()->json("created");
    }

}