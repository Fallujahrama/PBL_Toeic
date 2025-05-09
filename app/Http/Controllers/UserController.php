<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //menampilkan halaman profil
    public function profilePage()
    {
        $user = auth()->user();
        if (!$user) {
           return redirect('/login')->with('error', 'Silahkan login terlebih dahulu');
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

    //Menampilkan halaman form edit photo
    public function editPhoto(Request $request)
    {
        // Validasi file
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
                return redirect('/login')->with('error', 'User tidak ditemukan');
            }

            if ($userModel->foto_profil && file_exists(storage_path('app/public/' . $userModel->foto_profil))) {
                Storage::disk('public')->delete($userModel->foto_profil);
            }

            $fileName = 'profile_' . $userId . '_' . time() . '.' . $request->foto_profil->extension();
            $path = $request->foto_profil->storeAs('profiles', $fileName, 'public');

            UserModel::where('id_user', $userId)->update([
                'foto_profil' => $path
            ]);

            return redirect()->back()->with('success', 'Foto profile berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }
}
