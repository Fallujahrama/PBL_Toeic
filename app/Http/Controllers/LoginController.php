<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Check user level directly and redirect accordingly
            $user = Auth::user();
            if ($user->level && ($user->level->level_kode == 'AdmUpa' || $user->level->level_kode == 'SprAdmin')) {
                return redirect('/admin/dashboard');
            } elseif ($user->level && $user->level->level_kode == 'AdmITC') {
                return redirect('/admin/mahasiswa'); // Ubah ke path data mahasiswa
            } elseif ($user->level && in_array($user->level->level_kode, ['Mhs', 'Alum', 'Dsn', 'Cvts'])) {
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
                    $redirectUrl = '/welcome';

                    // Check level_kode directly without using getRole()
                    if ($user->level) {
                        $levelKode = $user->level->level_kode;

                        if ($levelKode == 'AdmUpa' || $levelKode == 'SprAdmin') {
                            $redirectUrl = '/admin/dashboard';
                        } elseif ($levelKode == 'AdmITC') {
                            $redirectUrl = '/admin/mahasiswa'; // Direct to Data Mahasiswa page
                        } elseif (in_array($levelKode, ['Mhs', 'Alum', 'Dsn', 'Cvts'])) {
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

    public function register()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        // Get non-admin user types for dropdown
        $userTypes = DB::table('level')
            ->whereIn('level_kode', ['Alum', 'Dsn', 'Cvts'])
            ->get();

        return view('auth.register', compact('userTypes'));
    }

    public function postRegister(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|min:4|max:20|unique:m_user,username',
                'password' => 'required|string|min:5|max:20|confirmed',
                'nama' => 'required|string|max:255',
                'level_id' => 'required|exists:level,level_id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            // Create user account in m_user table
            DB::table('m_user')->insert([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama' => $request->nama,
                'level_id' => $request->level_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Registration successful! You can now login to your account.',
                'redirect' => url('login')
            ]);

        } catch (\Exception $e) {
            Log::error('Registration error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'An error occurred during registration. Please try again later.'
            ], 500);
        }
    }
}
