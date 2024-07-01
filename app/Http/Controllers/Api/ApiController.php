<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    // Register API POST, FORM DATA
    public function register(Request $request){
        $request->validate([
            "name" => "required",
            "email"=> "required|email|unique:users",
            "password"=> "required|confirmed"
        ]);

        User::create([
            "name" => $request->name,
            "email"=> $request->email,
            "password" => Hash::make($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "User created successfully"
        ]);
    }

    // Login API POST, FORM DATA
    public function login(Request $request){
        // Data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // JWTAuth and attempt
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) { // Correct usage of attempt
            return response()->json([
                "status" => false,
                "message" => "Invalid login details"
            ], 401);
        }

        // Response
        return response()->json([
            "status" => true,
            "message" => "User logged in",
            "token" => $token
        ]);
    }

    // Profile API GET
    public function profile(){
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile Data",
            "user" => $userData
        ]);
    }

    // Refresh token API GET
    public function refreshToken(){
        $newToken = auth()-> refresh();

        return response()->json([
            "status" => true,
            "message" => "New Access token generated",
            "token" => $newToken
        ]);
        
    }

    // Logout API GET
    public function logout(){
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "Logout Successful"
        ]);
    }
}