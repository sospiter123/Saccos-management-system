<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

   public function register(Request $request)
{
    // 1. Validate
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6'
    ]);

    // 2. Create user with hashed password
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password'])
    ]);

    // 3. Return response
    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user
    ], 201);
}

public function login(Request $request)
{
    // 1. Validate
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string'
    ]);

    // 2. Check user exists and password is correct
    $user = User::where('email', $validated['email'])->first();

    if (!$user || !Hash::check($validated['password'], $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    // Delete old tokens
$user->tokens()->delete();

// Create new token
$token = $user->createToken('auth_token')->plainTextToken;

    // 4. Return response
    return response()->json([
        'message' => 'Login successful',
        'access_token' => $token,
        'token_type' => 'Bearer'
    ]);
}

public function logout(Request $request)
{
    // delete current token
}
}
