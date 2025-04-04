<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Token;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $user = Auth::user();

        // Simpan token baru tanpa menghapus token lama
        Token::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }



    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken()); // Buat token baru dari refresh token
            return response()->json([
                'message' => 'Token berhasil diperbarui',
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui token'], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                return response()->json(['message' => 'Token tidak ditemukan'], 400);
            }

            // Autentikasi user dari token
            $user = JWTAuth::authenticate($token);

            // Hapus semua token user dari database
            Token::where('user_id', $user->id)->delete();

            // Invalidate token yang digunakan
            JWTAuth::invalidate($token);

            return response()->json(['message' => 'Logout berhasil, semua sesi telah ditutup']);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Tidak dapat logout, token mungkin sudah kadaluarsa'], 500);
        }
    }

}
