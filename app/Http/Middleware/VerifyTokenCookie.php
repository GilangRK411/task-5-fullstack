<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyTokenCookie
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil token dari cookie
        $token = $request->cookie('token');

        if (!$token) {
            return response()->json(['message' => 'Token tidak ditemukan di cookie'], 401);
        }

        try {
            // Verifikasi token
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token tidak valid'], 401);
        }

        // Menambahkan user yang diautentikasi ke request untuk digunakan di controller
        $request->attributes->add(['user' => $user]);

        return $next($request);
    }
}

