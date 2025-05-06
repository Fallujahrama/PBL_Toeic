<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login berhasil',
                    'redirect' => route('dashboard')
                ]);
            }
    
            return redirect()->route('dashboard');
        }
    
        if ($request->ajax()) {
            return response()->json([
                'status' => false,
                'message' => 'Username atau password salah',
                'msgField' => [
                    'username' => ['Username tidak ditemukan atau salah'],
                    'password' => ['Password salah']
                ]
            ]);
        }
    
        // Jika bukan AJAX, tetap arahkan kembali ke login dengan error
        return redirect()->route('login')->withErrors([
            'login' => 'Username atau password salah'
        ]);
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

