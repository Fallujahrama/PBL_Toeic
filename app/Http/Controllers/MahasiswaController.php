<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        // Mendapatkan data untuk breadcrumb dan page title
        $breadcrumb = (object) [
            'title' => 'Data Mahasiswa',
            'list' => ['Home', 'Data Mahasiswa']
        ];

        $page = (object) [
            'title' => 'Daftar Mahasiswa'
        ];

        $activeMenu = 'mahasiswa';  // Menandakan menu aktif

        // Mengambil data mahasiswa yang akan ditampilkan
        $data = MahasiswaModel::select('nim', 'nama', 'jurusan', 'program_studi', 'kampus', 'no_whatsapp')->get();

        // Menampilkan halaman index mahasiswa
        return view('data_mahasiswa.index', compact('breadcrumb', 'page', 'activeMenu', 'data'));
    }
}
