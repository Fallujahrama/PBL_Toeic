<?php
namespace App\Http\Controllers;

class UserController extends Controller
{
    public function profilePage() 
    {
        // Dummy user sementara (misalnya dari database)
        $user = \App\Models\User::first(); // ambil user pertama dari tabel users
    
        // Pastikan ada data dummy
        if (!$user) {
            abort(404, 'Dummy user tidak ditemukan');
        }
    // 
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
    
    }