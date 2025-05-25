<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Storage;

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
}
