<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

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

//     // Tampilkan form edit profile
//     public function editProfilePage()
//     {
//         $user = auth()->user();
//         if (!$user) {
//             return redirect('/login')->with('error', 'Silahkan login terlebih dahulu');
//         }
//         $breadcrumb = (object) [
//             'title' => 'Edit Profile',
//             'list' => ['Home', 'Profile', 'Edit']
//         ];
//         $page = (object) [
//             'title' => 'Edit Profil Pengguna'
//         ];
//         $activeMenu = 'profile';
//         return view('user.edit_profile', compact('user', 'breadcrumb', 'page', 'activeMenu'));
//     }

//     // Proses update profile
//     public function updateProfile(Request $request)
//     {
//         $user = auth()->user();
//         if (!$user) {
//             return redirect('/login')->with('error', 'Silahkan login terlebih dahulu');
//         }

//         // Validasi sesuai role
//         if ($user->level_id == 1 || $user->level_id == 2) {
//             // Admin: username, nama, no_hp, password
//             $request->validate([
//                 'username' => 'required|string|max:50|unique:m_user,username,' . $user->id_user . ',id_user',
//                 'nama' => 'required|string|max:100',
//                 'no_hp' => 'required|string|max:20',
//                 'password' => 'nullable|string|min:6|confirmed',
//             ]);
//             // Update user
//             $userModel = \App\Models\UserModel::find($user->id_user);
//             $userModel->username = $request->username;
//             if ($request->filled('password')) {
//                 $userModel->password = Hash::make($request->password);
//             }
//             $userModel->save();
//             // Update admin
//             $admin = $userModel->admin()->first();
//             if ($admin) {
//                 $admin->nama = $request->nama;
//                 $admin->no_hp = $request->no_hp;
//                 $admin->save();
//             }
//         } elseif ($user->level_id == 3) {
//             // Mahasiswa: nama, password
//             $request->validate([
//                 'nama' => 'required|string|max:100',
//                 'password' => 'nullable|string|min:6|confirmed',
//             ]);
//             // Update user
//             $userModel = \App\Models\UserModel::find($user->id_user);
//             if ($request->filled('password')) {
//                 $userModel->password = Hash::make($request->password);
//             }
//             $userModel->save();
//             // Update mahasiswa
//             $mahasiswa = $userModel->mahasiswa;
//             if ($mahasiswa) {
//                 $mahasiswa->nama = $request->nama;
//                 $mahasiswa->save();
//             }
//         }

//         return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui');
//     }
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
}
