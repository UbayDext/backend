<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Salah email or password'
            ], 405);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ],
            'message' => 'Login Berhasil'
        ]);
    }
    public function logout(Request $request)
    {
        $user = $request->user();
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized or invalid token'
            ], 401);
        }
    
        $token = $user->currentAccessToken();
        if ($token) {
            $token->delete();
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Logout successful'
        ]);
    }
    
public function register(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'Cek lagi'
        ], 422);
    }

    // Buat user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Buat token
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'User registered successfully.',
        'data' => [
            'user' => $user,
            'token' => $token,
        ]
    ], 201);
}

}
