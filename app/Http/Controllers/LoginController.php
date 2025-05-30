<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Check user level directly and redirect accordingly
            $user = Auth::user();
            if ($user->level && in_array($user->level->level_kode, ['AdmUpa', 'AdmITC'])) {
                return redirect('/admin/dashboard');
            } elseif ($user->level && $user->level->level_kode == 'Mhs') {
                return redirect('/mahasiswa/pendaftaran');
            }
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        try {
            if ($request->ajax() || $request->wantsJson()) {
                $credentials = $request->only('username', 'password');
                
                // Add debugging
                Log::info('Login attempt', ['username' => $request->username]);

                if (Auth::attempt($credentials)) {
                    // Access user level directly through the relationship
                    $user = Auth::user();
                    $redirectUrl = '/';
                    
                    // Check level_kode directly without using getRole()
                    if ($user->level) {
                        $levelKode = $user->level->level_kode;
                        
                        if (in_array($levelKode, ['AdmUpa', 'AdmITC'])) {
                            $redirectUrl = '/admin/dashboard';
                        } elseif ($levelKode == 'Mhs') {
                            $redirectUrl = '/mahasiswa/dashboard';
                        }
                    }
                    
                    Log::info('Login successful', ['username' => $request->username, 'redirect' => $redirectUrl]);
                    
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Berhasil',
                        'redirect' => url($redirectUrl)
                    ]);
                }
                
                Log::warning('Login failed', ['username' => $request->username]);
                
                return response()->json([
                    'status' => false,
                    'message' => 'Username atau password salah'
                ]);
            }

            return redirect('login');
        } catch (\Exception $e) {
            Log::error('Login error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
