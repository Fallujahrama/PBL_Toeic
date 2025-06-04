<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\MahasiswaModel;
use App\Models\AdminModel;
use App\Models\PendaftaranModel;
use App\Models\SuratPernyataanModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Halaman profil pengguna
    public function profilePage()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        // Jika admin, ambil nama dari tabel admin
        if ($user->level_id == 1 || $user->level_id == 2) {
            $admin = $user->admin()->first(); // Relasi ke tabel admin
            $user->nama = $admin ? $admin->nama : $user->username; // Gunakan nama admin jika ada
        }

        // Jika mahasiswa, ambil nama dari tabel mahasiswa
        if ($user->level_id == 3) {
            $mahasiswa = $user->mahasiswa; // Relasi ke tabel mahasiswa
            if ($mahasiswa && $mahasiswa->nama) {
                $user->nama = $mahasiswa->nama; // Gunakan nama mahasiswa jika ada
            } else {
                $user->nama = "Nama Belum Diisi"; // Tampilkan default jika nama tidak ditemukan
            }
        }

        $breadcrumb = (object) [
            'title' => 'Profile User',
            'list' => ['Home', 'Profile']
        ];

        $page = (object) [
            'title' => 'Profil Pengguna'
        ];

        $activeMenu = 'profile';

        return view('user.profile', compact('user', 'breadcrumb', 'page', 'activeMenu'));
    }

    // Menyimpan foto profil baru
    public function editPhoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $user = auth()->user();
            if (!$user) {
                return redirect('/login')->with('error', 'Silahkan login terlebih dahulu');
            }

            $userId = $user->id_user;
            $userModel = UserModel::find($userId);

            if (!$userModel) {
                return redirect('/profile')->with('error', 'User tidak ditemukan');
            }

            // Hapus foto lama jika ada
            if ($userModel->foto_profil && Storage::disk('public')->exists($userModel->foto_profil)) {
                Storage::disk('public')->delete($userModel->foto_profil);
            }

            // Simpan foto baru
            $fileName = 'profile_' . $userId . '_' . time() . '.' . $request->foto_profil->extension();
            $path = $request->foto_profil->storeAs('profiles', $fileName, 'public');

            // Update di database
            $userModel->foto_profil = $path;
            $userModel->save();

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }

    // Edit profile admin
    public function editAdmin()
    {
        $user = auth()->user();
        return view('user.edit_admin', compact('user'));
    }

    public function updateAdmin(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            // 'username' => 'required|string|max:50|unique:m_user,username,' . $user->id_user . ',id_user',
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update user
        // $user->username = $request->username;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update admin table
        if ($user->admin) {
            $user->admin->nama = $request->nama;
            $user->admin->no_hp = $request->no_hp;
            $user->admin->save();
        }

        return redirect()->route('profile')->with('success', 'Profil admin berhasil diperbarui');
    }

    // Edit profile mahasiswa
    public function editMahasiswa()
    {
        $user = auth()->user();
        return view('user.edit_mahasiswa', compact('user'));
    }

    public function updateMahasiswa(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'nama' => 'required|string',
            'no_whatsapp' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update user
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update mahasiswa table
        if ($user->mahasiswa) {
            $user->mahasiswa->nama = $request->nama;
            $user->mahasiswa->no_whatsapp = $request->no_whatsapp;
            $user->mahasiswa->save();
        }

        return redirect()->route('profile')->with('success', 'Profil mahasiswa berhasil diperbarui');
    }

    // Admin User Management Methods
    public function adminIndex()
    {
        $users = UserModel::with('level')->paginate(10);
        
        $breadcrumb = (object) [
            'title' => 'Manajemen User',
            'list' => ['Home', 'Admin', 'Users']
        ];

        $page = (object) [
            'title' => 'Daftar User'
        ];

        $activeMenu = 'users';

        return view('admin.users.index', compact('users', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function create()
    {
        $levels = \App\Models\LevelModel::all();
        
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'Admin', 'Users', 'Create']
        ];

        $page = (object) [
            'title' => 'Tambah User Baru'
        ];

        $activeMenu = 'users';

        return view('admin.users.create', compact('levels', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        // Debug: Log semua data yang diterima
        Log::info('=== DEBUG CREATE USER ===');
        Log::info('All request data:', $request->all());
        Log::info('Nama field: ' . ($request->input('nama') ?? 'null'));
        Log::info('Username field: ' . ($request->input('username') ?? 'null'));
        Log::info('Level ID field: ' . ($request->input('level_id') ?? 'null'));

        try {
            // Validate input
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:m_user,username',
                'password' => 'required|string|min:6',
                'level_id' => 'required|exists:level,level_id',
            ]);

            Log::info('Validated data:', $validatedData);

            DB::beginTransaction();

            // Create user dengan data yang sudah divalidasi
            $userData = [
                'nama' => $validatedData['nama'],
                'username' => $validatedData['username'],
                'password' => Hash::make($validatedData['password']),
                'level_id' => $validatedData['level_id'],
            ];

            Log::info('User data to be created:', $userData);

            $user = UserModel::create($userData);

            Log::info('User created successfully:', $user->toArray());

            // Verify the user was created with nama
            $createdUser = UserModel::find($user->id_user);
            Log::info('User after creation (fresh from DB):', $createdUser->toArray());

            // Create related records based on user level
            if ($validatedData['level_id'] == 1 || $validatedData['level_id'] == 2 || $validatedData['level_id'] == 4) { 
                // Admin UPA, Admin ITC, or Super Admin
                $admin = AdminModel::create([
                    'user_id' => $user->id_user,
                    'nama' => $validatedData['nama'],
                    'no_hp' => '-'
                ]);
                Log::info('Admin record created:', $admin->toArray());
            } elseif ($validatedData['level_id'] == 3) { 
                // Mahasiswa - create basic record
                $mahasiswa = MahasiswaModel::create([
                    'nim' => $validatedData['username'],
                    'user_id' => $user->id_user,
                    'nama' => $validatedData['nama'],
                    'jurusan' => '-',
                    'alamat_asal' => '-',
                    'nik' => '-',
                    'no_whatsapp' => '-',
                    'kampus' => '-',
                    'program_studi' => '-',
                    'alamat_saat_ini' => '-',
                ]);
                Log::info('Mahasiswa record created:', $mahasiswa->toArray());
            }

            DB::commit();
            
            Log::info('=== USER CREATION SUCCESS ===');
            return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error:', $e->errors());
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $user = UserModel::with('level')->findOrFail($id);
        
        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'Admin', 'Users', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail User'
        ];

        $activeMenu = 'users';

        return view('admin.users.show', compact('user', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        $levels = \App\Models\LevelModel::all();
        
        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'Admin', 'Users', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User'
        ];

        $activeMenu = 'users';

        return view('admin.users.edit', compact('user', 'levels', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $user = UserModel::findOrFail($id);
            
            $request->validate([
                'nama' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:m_user,username,' . $id . ',id_user',
                'password' => 'nullable|string|min:6',
                'level_id' => 'required|exists:level,level_id',
            ]);

            // Update user table first
            $user->nama = $request->nama;
            $user->username = $request->username;
            $user->level_id = $request->level_id;
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();
            
            // Update related records based on user level
            if ($user->level_id == 1 || $user->level_id == 2 || $user->level_id == 4) { // Admin UPA, Admin ITC, or Super Admin
                $admin = AdminModel::where('user_id', $user->id_user)->first();
                if ($admin) {
                    $admin->nama = $request->nama;
                    $admin->save();
                } else {
                    // Create admin record if it doesn't exist
                    AdminModel::create([
                        'user_id' => $user->id_user,
                        'nama' => $request->nama,
                        'no_hp' => '-'
                    ]);
                }
            } elseif ($user->level_id == 3) { // Mahasiswa
                // For mahasiswa, we need to find by user_id, not nim
                $mahasiswa = MahasiswaModel::where('user_id', $user->id_user)->first();
                if (!$mahasiswa) {
                    // If not found by user_id, try to find by nim (username)
                    $mahasiswa = MahasiswaModel::where('nim', $user->username)->first();
                    if ($mahasiswa) {
                        // Update the mahasiswa record to include user_id
                        $mahasiswa->user_id = $user->id_user;
                    }
                }
                
                if ($mahasiswa) {
                    $mahasiswa->nama = $request->nama;
                    $mahasiswa->save();
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users.index')->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $user = UserModel::findOrFail($id);
            
            // Prevent deleting own account
            if ($user->id_user == auth()->id()) {
                return redirect()->route('admin.users.index')->with('error', 'Tidak dapat menghapus akun sendiri');
            }
            
            // Find mahasiswa record by user_id or username
            $mahasiswa = MahasiswaModel::where('user_id', $id)->first();
            if (!$mahasiswa) {
                $mahasiswa = MahasiswaModel::where('nim', $user->username)->first();
            }
            
            if ($mahasiswa) {
                // Delete all related pendaftaran records first
                PendaftaranModel::where('nim', $mahasiswa->nim)->delete();
                
                // Delete all related surat pernyataan records
                SuratPernyataanModel::where('nim', $mahasiswa->nim)->delete();
                
                // Delete mahasiswa record
                $mahasiswa->delete();
            }
            
            // Check if user has related admin records
            $admin = AdminModel::where('user_id', $id)->first();
            if ($admin) {
                $admin->delete();
            }
            
            // Delete user's profile photo if exists
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            
            // Finally delete the user
            $user->delete();
            
            DB::commit();
            
            return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users.index')->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
