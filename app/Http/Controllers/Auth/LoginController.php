<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Token; // Add model for storing tokens

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('articles.index');
        }

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Email or password is incorrect'], 401);
        }

        $user = Auth::user();

        Token::create([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        $cookie = cookie('token', $token, 60); // Token disimpan dalam cookie selama 60 menit


        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Login berhasil',
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ])->withCookie($cookie); // Mengirim token dalam cookie
            } else {
                // Jika bukan request API, redirect ke halaman utama
                return redirect()->route('articles.index')->withCookie($cookie);
        }
    }

    public function logout()
    {
        $user = Auth::user();

        Token::where('user_id', $user->id)->delete();

        JWTAuth::invalidate(JWTAuth::getToken());

        $cookie = cookie('token', '', -1);

        return response()->json(['message' => 'Successfully logged out'])->withCookie($cookie);
    }
}
