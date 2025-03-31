<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Token;
use Illuminate\Http\Request;

class VerifyToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // Cek apakah token ada di database
            $token = JWTAuth::getToken();
            $exists = Token::where('user_id', $user->id)->where('token', $token)->exists();

            if (!$exists) {
                return response()->json(['message' => 'Token tidak valid'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

