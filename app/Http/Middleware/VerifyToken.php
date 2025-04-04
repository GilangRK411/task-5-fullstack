<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Token;
use Illuminate\Http\Request;

class VerifyToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Ambil token dari request
            $token = JWTAuth::getToken();
            if (!$token) {
                return response()->json(['message' => 'Token tidak diberikan'], 401);
            }

            // Autentikasi user
            $user = JWTAuth::authenticate($token);
            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan'], 401);
            }

            // Cek apakah token masih valid di database
            $exists = Token::where('user_id', $user->id)
                ->where('token', $token)
                ->exists();
            if (!$exists) {
                return response()->json(['message' => 'Token tidak valid'], 401);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token kadaluarsa, silakan refresh'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Token tidak valid'], 401);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token tidak diberikan atau salah'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
