<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        return response()->json(['status' => 'success', 'message' => 'User registered successfully', 'user_details' => $user], 201);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($loginData)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return response()->json(['status' => 'success', 'message' => 'Login successful', 'user_details' => Auth::user(), 'token' => $accessToken], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getAllUser(){
        $users = User::orderBy('created_at', 'DESC')->get();
        return response()->json(['status' => 'success', 'users' => $users], 200);
    }
}
