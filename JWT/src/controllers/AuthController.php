<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        $user = User::where('username', $credentials['username'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $payload = [
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24 * 30
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'));

        return response()->json(['token' => $token]);
    }

    public function verify(Request $request)
    {
        try {
            $token = $request->bearerToken();
            $decoded = JWT::decode($token, env('JWT_SECRET'), ['HS256']);

            return response()->json(['valid' => true, 'user' => $decoded->sub]);
        } catch (Exception $e) {
            return response()->json(['valid' => false]);
        }
    }
}