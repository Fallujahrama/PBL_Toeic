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
            if ($user->level && $user->level->level_kode == 'AdmUpa') {
                return redirect('/admin/dashboard');
            } elseif ($user->level && $user->level->level_kode == 'AdmITC') {
                return redirect()->route('welcome');
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
                        
                        if ($levelKode == 'AdmUpa') {
                            $redirectUrl = '/admin/dashboard';
                        } elseif ($levelKode == 'AdmITC') {
                            $redirectUrl = route('welcome');
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
