<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){
      
        try{
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:5',
            'email' => 'required|email|unique:users'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ],201);
    }catch(ValidationException $exception){
        return response()->json(['errors' => $exception->errors()], 422);
    }
    }

    public function login(LoginRequest $request){

        $credencials = $request->only('email','password');
        
        try{
                if(!$token = JWTAuth::attempt($credencials)){
                    return response()->json([
                        'error' =>'invalid credentials'
                    ],400);
                }
        }catch(JWTException $e){
                return response()->json([
                    'error' => 'not create token'
                ],500);
        }
        return response()->json(compact('token'));
    }

}
